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

                            <div class="mb-4">
                                <label for="title">Assessment Title:</label>
                                <input type="text" id="title" name="title" required maxlength="20">
                            </div>

                            <div class="mb-4">
                                <label for="instruction">Instruction:</label>
                                <textarea id="instruction" name="instruction" required></textarea>
                            </div>

                            <div class="mb-4">
                                <label for="reviews_required">Number of Reviews Required:</label>
                                <input type="number" id="reviews_required" name="reviews_required" required min="1">
                            </div>

                            <div class="mb-4">
                                <label for="max_score">Maximum Score:</label>
                                <input type="number" id="max_score" name="max_score" required min="1" max="100">
                            </div>

                            <div class="mb-4">
                                <label for="due_date">Due Date:</label>
                                <input type="datetime-local" id="due_date" name="due_date" required>
                            </div>

                            <div class="mb-4">
                                <label for="type">Type:</label>
                                <select id="type" name="type" required>
                                    <option value="student-select">Student-Select</option>
                                    <option value="teacher-assign">Teacher-Assign</option>
                                </select>
                            </div>

                            <button type="submit">Add Assessment</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>