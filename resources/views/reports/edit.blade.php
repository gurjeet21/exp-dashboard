<x-app-layout>
    <x-slot name="header"><h1 class="text-2xl font-semibold text-gray-950">Wartungsbericht bearbeiten</h1></x-slot>
    <div class="py-8"><div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">@include('reports.partials.form', ['action' => route('reports.update', $report), 'method' => 'PUT'])</div></div>
</x-app-layout>
