@extends('layouts.app')

@section('content')
    <h1>Courses</h1>
    <ul>
        @foreach ($courses as $course)
            <li><a href="{{ route('courses.show', $course) }}">{{ $course->code }} - {{ $course->name }}</a></li>
        @endforeach
    </ul>
@endsection