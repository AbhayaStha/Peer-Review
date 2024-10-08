@extends('layouts.master')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $course->name }} {{ $course->course_code }}
    </h2>
@endsection

@section('content')
    <!-- Teachers Section -->
    <h3 class="mt-4 text-lg font-bold">Teachers:</h3>
    <ul class="list-disc pl-5">
        @forelse ($teachers as $teacher)
            <li>{{ $teacher->name }}</li>
        @empty
            <li>No teachers found.</li>
        @endforelse
    </ul><br>
    <!-- Enroll Students Button (for Teachers) -->
    @if (auth()->user()->isTeacher())
        <a href="{{ route('enrol', $course) }}" class="bg-orange-500 hover:bg-orange-700 text-black font-bold py-2 px-4 rounded-md border border-gray-300">
            Enroll Students
        </a>
    @endif
    <!-- Assessments Section -->
    <h3 class="mt-6 text-lg font-bold">Assessments:</h3>
    <ul class="list-disc pl-5">
        @forelse ($assessments as $assessment)
            <li>
                <a href="{{ route('assessments.show', $assessment) }}" class="text-blue-500 hover:underline">{{ $assessment->title }}</a> 
                (Due: {{ $assessment->due_date }})
            </li>
        @empty
            <li>No assessments found.</li>
        @endforelse
    </ul>

    <!-- Add Peer Review Assessment Form (for Teachers) -->
    @if (auth()->user()->isTeacher())
        <h3 class="mt-6 text-lg font-bold">Add Peer Review Assessment:</h3>
        <form action="{{ route('assessments.store') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="course_id" value="{{ $course->id }}">

            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Assessment Title:</label>
                <input type="text" name="title" id="title" maxlength="20" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Instructions -->
            <div>
                <label for="instruction" class="block text-sm font-medium text-gray-700">Instruction:</label>
                <textarea name="instruction" id="instruction" rows="4" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
            </div>

            <!-- Number of Reviews -->
            <div>
                <label for="num_required_reviews" class="block text-sm font-medium text-gray-700">Number of Reviews:</label>
                <input type="number" name="num_required_reviews" id="num_required_reviews" min="1" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Maximum Score -->
            <div>
                <label for="max_score" class="block text-sm font-medium text-gray-700">Maximum Score:</label>
                <input type="number" name="max_score" id="max_score" min="1" max="100" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Due Date -->
            <div>
                <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date:</label>
                <input type="datetime-local" name="due_date" id="due_date" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Type of Assessment -->
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700">Type:</label>
                <select name="type" id="type" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="student-select">Student-Select</option>
                    <option value="teacher-assign">Teacher-Assign</option>
                </select>
            </div>

            <!-- Submit Button -->
            <div class="mt-4">
                <button type="submit" class="bg-orange-500 hover:bg-orange-700 text-black font-bold py-2 px-4 rounded-md border border-gray-300">
                    Create Assessment
                </button>
            </div>
        </form>
    @endif
@endsection
