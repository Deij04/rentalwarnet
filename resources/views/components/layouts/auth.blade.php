<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        @livewireStyles
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800 flex items-center justify-center">
        <div class="w-full max-w-md p-6">
            {{ $slot }}
        </div>
        @livewireScripts
        @fluxScripts
    </body>
</html>