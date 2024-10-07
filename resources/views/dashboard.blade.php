<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (auth()->check())
                        <p>Welcome, <strong>{{ auth()->user()->name }}</strong> ({{ ucfirst(auth()->user()->type) }})!</p>

                        <h3 class="mt-4">Your Courses:</h3>
                        <ul>
                            @forelse (auth()->user()->courses as $course)
                                <li>
                                    <a href="{{ route('courses.show', $course) }}">{{ $course->code }} - {{ $course->name }}</a>
                                </li>
                            @empty
                                <li>No courses found.</li>
                            @endforelse
                        </ul>
                    @else
                        <p>Please log in to see your dashboard.</p>
                    @endif

                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

