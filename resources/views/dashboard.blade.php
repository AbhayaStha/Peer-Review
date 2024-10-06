@extends('layouts.app')

@section('content')
    <h1>Dashboard</h1>
    @if (auth()->check())
        <p>Welcome, {{ auth()->user()->name }}!</p>
        <ul>
            @foreach (auth()->user()->courses as $course)
                <li><a href="{{ route('courses.show', $course) }}">{{ $course->code }} - {{ $course->name }}</a></li>
            @endforeach
        </ul>
    @else
        <p>Please login to access your dashboard.</p>
    @endif
@endsection