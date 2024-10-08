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
    <p>Due date: {{ $assessment->due_date }}</p>

    <h3 class="mt-4">Submit Peer Review:</h3>
    @if (count($errors) > 0)
            <div style="padding: 15px; border-radius: 5px; margin-bottom: 20px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

<form action="{{ route('reviews.store') }}" method="POST">
    @csrf
    <input type="hidden" name="assessment_id" value="{{ $assessment->id }}">
    <div>
        <label for="reviewee">Select Reviewee:</label>
        <select name="reviewee_id" id="reviewee">
            @if ($assessment->type === 'teacher-assign')
                @foreach ($reviewees as $reviewee)
                    <option value="{{ $reviewee->user_id }}">{{ $reviewee->user->name }}</option>
                @endforeach
            @else
                @foreach ($studentsForReviews as $student)
                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                @endforeach
            @endif
        </select>
    </div>
    <div>
        <label for="review_text">Enter Review:</label>
        <textarea name="review_text" id="review_text" rows="5"></textarea>
    </div>
    <button type="submit" class="bg-orange-500 hover:bg-orange-700 text-black font-bold py-4 px-6 rounded border border-gray-300">
        Submit Review
    </button>
</form>
    @if (session('success'))
        <div class="text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="text-red-500">
            {{ session('error') }}
        </div>
    @endif

    <h3 class="mt-4">Peer Reviews Received:</h3>
    <ul>
        @foreach ($reviews as $review)
            <li>
                {{ $review->reviewer->name }}: {{ $review->review_text }}
            </li>
        @endforeach
    </ul>
@endsection