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

                        @if (auth()->user()->isStudent())
                            <h3 class="mt-4">Your Enrolled Courses:</h3>
                            <ul>
                                @forelse (auth()->user()->studentCourses as $course)
                                    <li>
                                        <a href="{{ route('courses.show', $course) }}">{{ $course->code }} - {{ $course->name }}</a>
                                    </li>
                                @empty
                                    <li>No enrolled courses found.</li>
                                @endforelse
                            </ul>

                            <h3 class="mt-4">Open Courses:</h3>
                            <ul>
                                @forelse (App\Models\Course::whereNotIn('id', auth()->user()->studentCourses->pluck('id'))->get() as $course)
                                    <li>
                                        <a href="{{ route('courses.show', $course) }}">{{ $course->code }} - {{ $course->name }}</a>
                                        <form action="{{ route('enrollments.store', 'enroll') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                            <button type="submit" class="bg-orange-500 hover:bg-orange-700 text-black font-bold py-4 px-6 rounded border border-gray-300">
                                                Enroll
                                            </button>
                                        </form>
                                    </li>
                                @empty
                                    <li>No open courses found.</li>
                                @endforelse
                            </ul>
                        @endif

                        @if (auth()->user()->isTeacher())
                            <h3 class="mt-4">Your Taught Courses:</h3>
                            <ul>
                                @forelse (auth()->user()->teacherCourses as $course)
                                    <li>
                                        <a href="{{ route('courses.show', $course) }}">{{ $course->code }} - {{ $course->name }}</a>
                                    </li>
                                @empty
                                    <li>No taught courses found.</li>
                                @endforelse
                            </ul>

                            <h3 class="mt-4">Available Courses to Teach:</h3>
                            @if (session('error'))
                                <div class="text-red-500">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <ul>
                                @forelse (App\Models\Course::whereNotIn('id', auth()->user()->teacherCourses->pluck('id'))->get() as $course)
                                    <li>
                                        <a href="{{ route('courses.show', $course) }}">{{ $course->code }} - {{ $course->name }}</a>
                                        <form action="{{ route('enrollments.store', 'teach') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                            <button type="submit" class="bg-orange-500 hover:bg-orange-700 text-black font-bold py-4 px-6 rounded border border-gray-300">
                                                Teach
                                            </button>
                                        </form>
                                    </li>
                                @empty
                                    <li>No available courses to teach.</li>
                                @endforelse
                            </ul>
                        @endif
                    @else
                        <p>Please log in to see your dashboard.</p>
                    @endif

                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>