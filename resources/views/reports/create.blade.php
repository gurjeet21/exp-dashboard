<x-app-layout>
    <x-slot name="header"><h1 class="text-2xl font-semibold text-gray-950">Neuer Wartungsbericht</h1></x-slot>
    <div class="py-8"><div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">@include('reports.partials.form', ['action' => route('reports.store'), 'method' => 'POST'])</div></div>
</x-app-layout>
