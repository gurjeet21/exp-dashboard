<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">{{ __('app.reports.eyebrow') }}</p>
                <h1 class="mt-1 text-2xl font-semibold text-gray-950">{{ __('app.reports.title') }}</h1>
            </div>
            <a href="{{ route('reports.create') }}" wire:navigate class="rounded-md bg-gray-950 px-4 py-2 text-sm font-semibold text-white">{{ __('app.reports.new') }}</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <form method="GET" action="{{ route('reports.index') }}" class="mb-6 rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                <div class="grid gap-4 lg:grid-cols-6">
                    <div class="lg:col-span-2">
                        <label for="search" class="text-xs font-semibold uppercase text-gray-500">{{ __('app.filters.search') }}</label>
                        <input id="search" name="search" value="{{ $filters['search'] ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm" placeholder="{{ __('app.reports.search_placeholder') }}">
                    </div>
                    <div>
                        <label for="status" class="text-xs font-semibold uppercase text-gray-500">{{ __('app.filters.status') }}</label>
                        <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm">
                            <option value="">{{ __('app.all') }}</option>
                            <option value="draft" @selected(($filters['status'] ?? '') === 'draft')>{{ __('app.status.draft') }}</option>
                            <option value="final" @selected(($filters['status'] ?? '') === 'final')>{{ __('app.status.final') }}</option>
                        </select>
                    </div>
                    <div>
                        <label for="year" class="text-xs font-semibold uppercase text-gray-500">{{ __('app.filters.year') }}</label>
                        <input id="year" name="year" type="number" min="2020" max="2100" value="{{ $filters['year'] ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm" placeholder="2026">
                    </div>
                    <div>
                        <label for="month" class="text-xs font-semibold uppercase text-gray-500">{{ __('app.filters.month') }}</label>
                        <select id="month" name="month" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm">
                            <option value="">{{ __('app.all') }}</option>
                            @foreach (range(1, 12) as $month)
                                <option value="{{ $month }}" @selected((string) ($filters['month'] ?? '') === (string) $month)>{{ str_pad((string) $month, 2, '0', STR_PAD_LEFT) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="project_id" class="text-xs font-semibold uppercase text-gray-500">{{ __('app.projects.columns.project') }}</label>
                        <select id="project_id" name="project_id" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm">
                            <option value="">{{ __('app.filters.all_projects') }}</option>
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}" @selected((string) ($filters['project_id'] ?? '') === (string) $project->id)>{{ $project->client->company_name }} · {{ $project->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-4 grid gap-4 sm:grid-cols-4">
                    <div>
                        <label for="date_from" class="text-xs font-semibold uppercase text-gray-500">{{ __('app.filters.date_from') }}</label>
                        <input id="date_from" name="date_from" type="date" value="{{ $filters['date_from'] ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm">
                    </div>
                    <div>
                        <label for="date_to" class="text-xs font-semibold uppercase text-gray-500">{{ __('app.filters.date_to') }}</label>
                        <input id="date_to" name="date_to" type="date" value="{{ $filters['date_to'] ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm">
                    </div>
                    <div>
                        <label for="per_page" class="text-xs font-semibold uppercase text-gray-500">{{ __('app.filters.per_page') }}</label>
                        <select id="per_page" name="per_page" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm">
                            @foreach ([12, 25, 50, 100] as $size)
                                <option value="{{ $size }}" @selected((int) request('per_page', 12) === $size)>{{ $size }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end gap-2">
                        <button class="rounded-md bg-gray-950 px-4 py-2 text-sm font-semibold text-white">{{ __('app.apply') }}</button>
                        <a href="{{ route('reports.index') }}" wire:navigate class="rounded-md border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-700">{{ __('app.reset') }}</a>
                    </div>
                </div>
            </form>

            <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">{{ __('app.reports.columns.report') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">{{ __('app.reports.columns.client') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">{{ __('app.reports.columns.hours') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">{{ __('app.reports.columns.status') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($reports as $report)
                            <tr>
                                <td class="px-6 py-4">
                                    <a href="{{ route('reports.show', $report) }}" wire:navigate class="font-semibold text-gray-950 hover:text-gray-700">Wartungsbericht {{ $report->period_to?->format('m/Y') ?: $report->created_at->format('m/Y') }}</a>
                                    <p class="text-sm text-gray-500">{{ $report->project->name }}</p>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $report->project->client->company_name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $report->total_hours }} Std.</td>
                                <td class="px-6 py-4"><span class="rounded-md bg-gray-100 px-2 py-1 text-xs font-semibold text-gray-700">{{ __('app.status.'.$report->status) }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-6 py-10 text-center text-sm text-gray-500">{{ __('app.reports.no_reports') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $reports->links() }}</div>
        </div>
    </div>
</x-app-layout>
