<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-slate-100 font-sans antialiased text-slate-900">
        <div class="min-h-screen lg:grid lg:grid-cols-[280px_1fr]">
            <livewire:layout.navigation />

            <div class="min-w-0">
                <div class="hidden h-20 items-center justify-between border-b border-slate-200 bg-white px-6 lg:flex">
                    <div class="w-full max-w-xl rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-500">
                        Search clients, projects, tasks...
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="inline-flex rounded-full border border-slate-200 bg-white p-1 text-sm">
                            <span class="rounded-full bg-neutral-800 px-3 py-1 font-semibold text-white">DE</span>
                            <span class="px-3 py-1 text-slate-500">EN</span>
                        </div>
                        <div class="grid h-11 w-11 place-items-center rounded-full bg-neutral-800 text-sm font-bold text-white">
                            {{ collect(explode(' ', auth()->user()->name))->map(fn ($part) => mb_substr($part, 0, 1))->take(2)->implode('') }}
                        </div>
                    </div>
                </div>

                @if (isset($header))
                    <header class="border-b border-slate-200 bg-white lg:bg-slate-50">
                        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <main>
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
