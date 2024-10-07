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
@endsection