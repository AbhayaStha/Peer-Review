@extends('layouts.master')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Edit Assessment
    </h2>
@endsection

@section('content')
    <form action="{{ route('assessments.update', $assessment) }}" method="POST" class="space-y-4">
        @csrf
        @method('patch')

        <!-- Title -->
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700">Title:</label>
            <input type="text" name="title" id="title" value="{{ $assessment->title }}" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <!-- Instruction -->
        <div>
            <label for="instruction" class="block text-sm font-medium text-gray-700">Instruction:</label>
            <textarea name="instruction" id="instruction" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ $assessment->instruction }}</textarea>
        </div>

        <!-- Number of required reviews -->
        <div>
            <label for="num_required_reviews" class="block text-sm font-medium text-gray-700">Number of required reviews:</label>
            <input type="number" name="num_required_reviews" id="num_required_reviews" value="{{ $assessment->num_required_reviews }}" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div>
            <label for="max_score" class="block text-sm font-medium text-gray-700">Max score:</label>
            <input type="number" name="max_score" id="max_score" value="{{ $assessment->max_score }}" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <!-- Due date -->
        <div>
            <label for="due_date" class="block text-sm font-medium text-gray-700">Due date:</label>
            <input type="datetime-local" name="due_date" id="due_date" value="{{ $assessment->due_date }}" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div><br>

        <!-- Submit Button -->
        <button type="submit" class="bg-orange-500 hover:bg-orange-700 text-black font-bold py-2 px-4 rounded-md border border-gray-300">
            Update Assessment
        </button>
    </form>
@endsection