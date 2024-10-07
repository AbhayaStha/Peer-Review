<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $course->name }} ({{ $course->code }})
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="mt-4">Teachers:</h3>
                    <ul>
                        @forelse ($teachers as $teacher)
                            <li>{{ $teacher->name }}</li>
                        @empty
                            <li>No teachers found.</li>
                        @endforelse
                    </ul>

                    <h3 class="mt-4">Assessments:</h3>
                    <ul>
                        @forelse ($assessments as $assessment)
                            <li>
                                <a href="{{ route('assessments.show', $assessment) }}">{{ $assessment->title }}</a> (Due: {{ $assessment->due_date }})
                            </li>
                        @empty
                            <li>No assessments found.</li>
                        @endforelse
                    </ul>

                    @if (auth()->user()->isTeacher())
                        <h3 class="mt-4">Add Peer Review Assessment:</h3>
                        <form action="{{ route('assessments.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                            <div>
                                <label for="title">Assessment Title:</label>
                                <input type="text" name="title" id="title" maxlength="20">
                            </div>
                            <div>
                                <label for="instruction">Instruction:</label>
                                <textarea name="instruction" id="instruction"></textarea>
                            </div>
                            <div>
                                <label for="num_reviews">Number of Reviews:</label>
                                <input type="number" name="num_reviews" id="num_reviews" min="1">
                            </div>
                            <div>
                                <label for="max_score">Maximum Score:</label>
                                <input type="number" name="max_score" id="max_score" min="1" max="100">
                            </div>
                            <div>
                                <label for="due_date">Due Date:</label>
                                <input type="datetime-local" name="due_date" id="due_date">
                            </div>
                            <div>
                                <label for="type">Type:</label>
                                <select name="type" id="type">
                                    <option value="student-select">Student-Select</option>
                                    <option value="teacher-assign">Teacher-Assign</option>
                                </select>
                            </div>
                            <button type="submit" class="bg-orange-500 hover:bg-orange-700 text-black font-bold py-4 px-6 rounded border border-gray-300">
                                Create Assessment
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>