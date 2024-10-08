@extends('layouts.master')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $assessment->title }}
    </h2>
@endsection

@section('content')
    <h3 class="mt-4">Assessment Details:</h3>
    <p>Instruction: {{ $assessment->instruction }}</p>
    <p>Number of required reviews: {{ $numRequiredReviews }}</p>
    <p>Due date: {{ $assessment->due_date }}</p><br>

    <!-- Edit Assessment Button -->
    @if (!$assessment->hasSubmission())
        <a href="{{ route('assessments.edit', $assessment) }}" class="bg-orange-500 hover:bg-orange-700 text-black font-bold py-2 px-4 rounded-md border border-gray-300">
            Edit Assessment
        </a>
    @endif

    <!-- Groups Section -->
    @if ($assessment->type !== 'student-select')
    <h3 class="mt-4">Groups:</h3>
    <ul class="list-disc pl-5">
        @foreach ($groups as $group)
            <li>
                <a href="{{ route('groups.show', $group) }}" class="text-blue-500 hover:underline">{{ $group->group_name }}</a>
            </li>
        @endforeach
    </ul>

    <!-- Create Group Form -->
    <h3 class="mt-6">Create Group:</h3>
    <form action="{{ route('groups.store') }}" method="POST" class="space-y-4">
        @csrf
        <input type="hidden" name="assessment_id" value="{{ $assessment->id }}">

        <!-- Group Name -->
        <div>
            <label for="group_name" class="block text-sm font-medium text-gray-700">Group Name:</label>
            <input type="text" name="group_name" id="group_name" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <!-- Select Students (Excluding Teachers) -->
        <div>
            <label for="students" class="block text-sm font-medium text-gray-700">Select Students:</label>
            @foreach ($students->filter(fn($student) => !$student->is_teacher) as $student) <!-- Filtering out teachers -->
                <div class="flex items-center">
                    <input type="checkbox" name="students[]" value="{{ $student->id }}" class="mr-2">
                    <label class="text-gray-700">{{ $student->name }}</label>
                </div>
            @endforeach
        </div>

        <!-- Submit Button -->
        <button type="submit" class="bg-orange-500 hover:bg-orange-700 text-black font-bold py-2 px-4 rounded-md border border-gray-300">
            Create Group
        </button>
    </form>
@endif


    <!-- Student Reviews Section -->
    <h3 class="mt-6">Student Reviews:</h3>
    <ul class="list-disc pl-5">
        @forelse ($students->filter(fn($student) => !$student->is_teacher) as $student) <!-- Filtering out teachers -->
            <li>
                <a href="{{ route('reviews.show', ['user' => $student, 'assessment' => $assessment]) }}" class="text-blue-500 hover:underline">{{ $student->name }}</a>
                (Submitted: {{ $student->reviewsGiven()->where('assessment_id', $assessment->id)->count() }}, 
                Received: {{ $student->reviewsReceived()->where('assessment_id', $assessment->id)->count() }})
            </li>
        @empty
            <li>No students found.</li>
        @endforelse
    </ul>
@endsection