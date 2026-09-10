<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">{{ $report->project->client->company_name }} · {{ $report->project->name }}</p>
                <h1 class="mt-1 text-2xl font-semibold text-gray-950">Wartungsbericht {{ $report->period_to?->format('m/Y') }}</h1>
            </div>
            <a href="{{ route('reports.edit', $report) }}" wire:navigate class="rounded-md border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-700">Edit</a>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            @include('reports.partials.preview', ['report' => $report])
        </div>
    </div>
</x-app-layout>
