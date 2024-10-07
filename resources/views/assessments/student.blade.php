<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $assessment->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="mt-4">Assessment Details:</h3>
                    <p>Title: {{ $assessment->title }}</p>
                    <p>Instruction: {{ $assessment->instruction }}</p>
                    <p>Number of Required Reviews: {{ $assessment->num_required_reviews }}</p>
                    <p>Due Date: {{ $assessment->due_date }}</p>

                    <h3 class="mt-4">Submit Review:</h3>
                    <form action="{{ route('reviews.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="assessment_id" value="{{ $assessment->id }}">

                        <div class="mb-4">
                            <label for="reviewee_id">Select Reviewee:</label>
                            <select id="reviewee_id" name="reviewee_id" required>
                                @foreach ($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="review_text">Enter Review:</label>
                            <textarea id="review_text" name="review_text" required></textarea>
                        </div>

                        <button type="submit">Submit Review</button>
                    </form>

                    <h3 class="mt-4">Reviews Received:</h3>
                    <ul>
                        @forelse ($reviews as $review)
                            <li>
                                {{ $review->reviewer->name }}: {{ $review->review_text }}
                            </li>
                        @empty
                            <li>No reviews received.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>