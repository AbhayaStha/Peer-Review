@extends('layouts.app')

@section('content')
    <h1>{{ $course->code }} - {{ $course->name }}</h1>
    <p>Assessments:</p>
    <ul>
        @foreach ($course->assessments as $assessment)
            <li><a href="{{ route('assessments.show', $assessment) }}">{{ $assessment->title }}</a></li>
        @endforeach
    </ul>
@endsection