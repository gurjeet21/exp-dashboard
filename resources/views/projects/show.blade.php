<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">{{ $project->client->company_name }}</p>
                <h1 class="mt-1 text-2xl font-semibold text-gray-950">{{ $project->name }}</h1>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('reports.create', ['project' => $project->id]) }}" wire:navigate class="rounded-md bg-gray-950 px-4 py-2 text-sm font-semibold text-white">New Report</a>
                <a href="{{ route('projects.edit', $project) }}" wire:navigate class="rounded-md border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-700">Edit</a>
            </div>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="mx-auto grid max-w-7xl gap-6 px-4 sm:px-6 lg:grid-cols-3 lg:px-8">
            <section class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="text-base font-semibold text-gray-950">Details</h2>
                <dl class="mt-4 space-y-3 text-sm">
                    <div><dt class="text-gray-500">Website</dt><dd class="font-medium text-gray-900">{{ $project->website_url ?: '-' }}</dd></div>
                    <div><dt class="text-gray-500">Type</dt><dd class="font-medium text-gray-900">{{ ucfirst($project->type) }}</dd></div>
                    <div><dt class="text-gray-500">Monthly price</dt><dd class="font-medium text-gray-900">{{ $project->monthly_price ? '€'.$project->monthly_price : '-' }}</dd></div>
                    <div><dt class="text-gray-500">Assigned</dt><dd class="font-medium text-gray-900">{{ $project->assignedUser?->name ?: '-' }}</dd></div>
                </dl>
            </section>
            <section class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm lg:col-span-2">
                <div class="flex items-center justify-between">
                    <h2 class="text-base font-semibold text-gray-950">Maintenance Reports</h2>
                    <a href="{{ route('reports.create', ['project' => $project->id]) }}" wire:navigate class="text-sm font-semibold text-gray-900">Create Report</a>
                </div>
                <div class="mt-4 divide-y divide-gray-100">
                    @forelse ($project->maintenanceReports as $report)
                        <a href="{{ route('reports.show', $report) }}" wire:navigate class="block py-3">
                            <p class="font-semibold text-gray-950">Wartungsbericht {{ $report->period_to?->format('m/Y') ?: $report->created_at->format('m/Y') }}</p>
                            <p class="text-sm text-gray-500">{{ ucfirst($report->status) }} · {{ $report->total_hours }} Std.</p>
                        </a>
                    @empty
                        <p class="py-8 text-sm text-gray-500">No reports yet.</p>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
