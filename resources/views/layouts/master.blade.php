<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peer Review System</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <x-app-layout>
        <x-slot name="header">
            @if (auth()->check())
                <p><strong>{{ auth()->user()->name }}</strong> ({{ ucfirst(auth()->user()->type) }})</p>
            @endif
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <!-- {{ __('Dashboard') }} -->
                @yield('header')
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>