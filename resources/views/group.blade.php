@extends('layouts.master')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $group->group_name }}
    </h2>
@endsection

@section('content')
    <h3 class="mt-4">Students in {{ $group->group_name }}:</h3>
    <ul>
        @foreach ($students as $student)
            <li>
                {{ $student->user->name }}
                @foreach ($ratings[$student->id] as $rating)
                    ({{ $rating->score }})
                @endforeach
            </li>
        @endforeach
    </ul>
@endsection