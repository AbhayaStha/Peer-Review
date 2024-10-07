<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $group->group_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
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
                </div>
            </div>
        </div>
    </div>
</x-app-layout>