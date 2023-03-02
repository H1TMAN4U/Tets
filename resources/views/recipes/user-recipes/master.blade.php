<x-app-layout>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/dark-light-mode.js'])
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-center">
        @yield('content')
    </div>
</x-app-layout>

