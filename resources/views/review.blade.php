@extends('layouts.master')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Reviews for {{ $user->name }}
    </h2>
@endsection

@section('content')
    <h3 class="mt-4">Reviews Submitted:</h3>
    <ul>
        @if($reviewsGiven)
            @forelse ($reviewsGiven as $review)
                <li>
                    @if($review->reviewee)
                        {{ $review->reviewee->name }}: {{ $review->review_text }}
                    @else
                        Reviewee not found: {{ $review->review_text }}
                    @endif
                </li>
            @empty
                <li>No reviews submitted.</li>
            @endforelse
        @else
            <li>No reviews submitted.</li>
        @endif
    </ul>

    <h3 class="mt-4">Reviews Received:</h3>
    <ul>
        @if($reviewsReceived)
            @forelse ($reviewsReceived as $review)
                <li>
                    {{ $review->reviewer->name }}: {{ $review->review_text }}
                </li>
            @empty
                <li>No reviews received.</li>
            @endforelse
        @else
            <li>No reviews received.</li>
        @endif
    </ul>

    <h3 class="mt-4">Assign Score:</h3>
    <form action="{{ route('markings.store') }}" method="POST" class="space-y-4">
        @csrf
        <input type="hidden" name="assessment_id" value="{{ $assessment->id }}">
        <input type="hidden" name="student_id" value="{{ $user->id }}">

        <!-- Score -->
        <div>
            <label for="mark" class="block text-sm font-medium text-gray-700">Score (out of {{ $assessment->max_score }}):</label>
            <input type="number" name="mark" id="mark" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <!-- Submit Button -->
        <button type="submit" class="bg-orange-500 hover:bg-orange-700 text-black font-bold py-2 px-4 rounded-md border border-gray-300">
            Assign Score
        </button>
    </form>
@endsection