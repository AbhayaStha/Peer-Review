<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $assessment->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                <h3 class="mt-4">Groups:</h3>
                    <ul>
                        @foreach ($groups as $group)
                            <li>
                                <a href="{{ route('groups.show', $group) }}">{{ $group->group_name }}</a>
                            </li>
                        @endforeach
                    </ul>
                <h3 class="mt-4">Create Group:</h3>
                <form action="{{ route('groups.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="assessment_id" value="{{ $assessment->id }}">
                    <div>
                        <label for="group_name">Group Name:</label>
                        <input type="text" name="group_name" id="group_name">
                    </div>
                    <div>
                        <label for="students">Select Students:</label>
                        @foreach ($students as $student)
                            <div>
                                <input type="checkbox" name="students[]" value="{{ $student->id }}">
                                <label>{{ $student->name }}</label>
                            </div>
                        @endforeach
                    </div>
                    <button type="submit" class="bg-orange-500 hover:bg-orange-700 text-black font-bold py-4 px-6 rounded border border-gray-300">
                        Create Group
                    </button>
                </form>
                <h3 class="mt-4">Student Reviews:</h3>
                    <ul>
                        @forelse ($students as $student)
                            <li>
                                <a href="{{ route('reviews.show', $student) }}">{{ $student->name }}</a>
                                (Submitted: {{ $student->reviewsGiven()->where('assessment_id', $assessment->id)->count() }}, Received: {{ $student->reviewsReceived()->where('assessment_id', $assessment->id)->count() }})
                            </li>
                        @empty
                            <li>No students found.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>