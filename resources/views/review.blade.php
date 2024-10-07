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
                        @forelse ($reviews as $review)
                            <li>
                                {{ $review->reviewee->name }}: {{ $review->review }}
                            </li>
                        @empty
                            <li>No reviews submitted.</li>
                        @endforelse
                    </ul>

                    <h3 class="mt-4">Reviews Received:</h3>
                    <ul>
                        @forelse ($reviewsReceived as $review)
                            <li>
                                {{ $review->reviewer->name }}: {{ $review->review }}
                            </li>
                        @empty
                            <li>No reviews received.</li> @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>