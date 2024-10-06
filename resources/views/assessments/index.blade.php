@extends('layouts.app')

@section('content')
    <h1>Assessments</h1>
    <ul>
        @foreach ($assessments as $assessment)
            <li><a href="{{ route('assessments.show', $assessment) }}">{{ $assessment->title }}</a></li>
        @endforeach
    </ul>
@endsection