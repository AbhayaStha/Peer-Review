<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Reviews for {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
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
                </div>
            </div>
        </div>
    </div>
</x-app-layout>