@extends('layouts.app')

@section('content')
    <h1>{{ $assessment->title }}</h1>
    <p>Reviews:</p>
    <ul>
        @foreach ($assessment->reviews as $review)
            <li>{{ $review->review_text }} ({{ $review->reviewer->name }})</li>
        @endforeach
    </ul>
@endsection