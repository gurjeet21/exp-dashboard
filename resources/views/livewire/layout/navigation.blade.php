<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

@php
    $navItems = [
        ['label' => 'Dashboard', 'route' => 'dashboard', 'active' => request()->routeIs('dashboard'), 'count' => '24'],
        ['label' => 'Kunden', 'route' => 'clients.index', 'active' => request()->routeIs('clients.*')],
        ['label' => 'Projekte', 'route' => 'projects.index', 'active' => request()->routeIs('projects.*')],
        ['label' => 'Wartungsberichte', 'route' => 'reports.index', 'active' => request()->routeIs('reports.*')],
    ];

    $plannedItems = ['Aufgaben', 'Dateien', 'Tickets', 'Rechnungen', 'Einstellungen'];
@endphp

<nav x-data="{ open: false }" class="border-b border-slate-200 bg-white lg:border-b-0 lg:bg-neutral-900">
    <div class="flex h-16 items-center justify-between px-4 lg:hidden">
        <a href="{{ route('dashboard') }}" wire:navigate>
            <x-application-logo class="block h-10 w-auto" />
        </a>

        <button @click="open = ! open" class="inline-flex items-center justify-center rounded-md p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-700">
            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <aside class="hidden min-h-screen flex-col bg-neutral-900 px-5 py-7 text-white lg:flex">
        <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-4">
            <div class="rounded-lg bg-white p-2">
                <x-application-logo class="h-10 w-auto" />
            </div>
            <div>
                <div class="text-lg font-bold">eXP Designs</div>
                <div class="text-sm text-neutral-300">Client Portal</div>
            </div>
        </a>

        <div class="mt-8 grid gap-2">
            @foreach ($navItems as $item)
                <a href="{{ route($item['route']) }}" wire:navigate @class([
                    'flex items-center justify-between rounded-lg px-4 py-3 text-sm font-semibold transition',
                    'bg-neutral-700 text-white' => $item['active'],
                    'text-neutral-200 hover:bg-neutral-800 hover:text-white' => ! $item['active'],
                ])>
                    <span>{{ $item['label'] }}</span>
                    @if (isset($item['count']))
                        <span>{{ $item['count'] }}</span>
                    @endif
                </a>
            @endforeach

            @foreach ($plannedItems as $label)
                <span class="rounded-lg px-4 py-3 text-sm font-medium text-neutral-400">{{ $label }}</span>
            @endforeach
        </div>

        <div class="mt-auto rounded-lg border border-neutral-700 bg-neutral-800 p-4 text-sm text-neutral-300">
            <p class="font-semibold text-white">Client visibility</p>
            <p class="mt-1">Aufgaben, Dateien und Berichte können später pro Kunde sichtbar oder intern bleiben.</p>
        </div>
    </aside>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @foreach ($navItems as $item)
                <x-responsive-nav-link :href="route($item['route'])" :active="$item['active']" wire:navigate>
                    {{ $item['label'] }}
                </x-responsive-nav-link>
            @endforeach
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                <div class="font-medium text-sm text-gray-500">{{ auth()->user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile')" wire:navigate>
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link>
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </button>
            </div>
        </div>
    </div>
</nav>
