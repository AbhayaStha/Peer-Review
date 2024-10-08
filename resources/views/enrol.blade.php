@extends('layouts.master')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Enroll Students in {{ $course->name }}
    </h2>
@endsection

@section('content')
    <h3 class="mt-4">Enrolled Students:</h3>
    <ul>
        @forelse ($course->enrollments()->where('role', 'student')->get() as $enrollment)
            <li>{{ $enrollment->user->name }}</li>
        @empty
            <li>No students enrolled.</li>
        @endforelse
    </ul>

    <h3 class="mt-6">Select Students to Enroll:</h3>
    <form action="{{ route('courses.enroll.store', $course) }}" method="POST" class="space-y-4">
        @csrf
        @foreach ($availableStudents as $student)
            <div class="flex items-center">
                <input type="checkbox" name="user_ids[]" value="{{ $student->id }}" class="mr-2">
                <label class="text-gray-700">{{ $student->name }}</label>
            </div>
        @endforeach

        <!-- Submit Button -->
        <button type="submit" class="bg-orange-500 hover:bg-orange-700 text-black font-bold py-2 px-4 rounded-md border border-gray-300">
            Enroll Students
        </button>
    </form>
@endsection