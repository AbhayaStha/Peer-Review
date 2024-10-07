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