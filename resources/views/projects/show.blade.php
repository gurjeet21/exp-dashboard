@php
    $folderSections = [
        [
            'title' => 'Project Documents',
            'description' => 'Website content, legal PDFs, contracts, approvals and briefing files.',
            'url' => $project->project_documents_url,
            'status' => $project->project_documents_url ? 'Linked' : 'Not linked',
        ],
        [
            'title' => 'Project Related Images',
            'description' => 'Logos, banners, screenshots, image material and design assets.',
            'url' => $project->project_images_url,
            'status' => $project->project_images_url ? 'Linked' : 'Not linked',
        ],
        [
            'title' => 'Maintenance Reports',
            'description' => 'Monthly reports for this project with tasks, hours, PDF and email workflow.',
            'url' => route('reports.create', ['project' => $project->id]),
            'status' => $project->maintenanceReports->count().' reports',
        ],
        [
            'title' => 'Tasks / Control Center',
            'description' => 'Internal tasks, client-visible tasks, developer, dates, status and hours.',
            'url' => null,
            'status' => 'Planned',
        ],
        [
            'title' => 'Tresor / Zugangsdaten',
            'description' => 'Hosting, CMS, FTP, email, API keys and protected project access data.',
            'url' => $project->access_vault_url,
            'status' => $project->access_vault_url ? 'Internal link' : 'Internal only',
        ],
        [
            'title' => 'Tickets',
            'description' => 'Client issues and requests that can later be assigned to your team.',
            'url' => null,
            'status' => 'Planned',
        ],
    ];
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold text-slate-500">{{ $project->client->company_name }}</p>
                <h1 class="mt-2 text-3xl font-bold text-slate-950">{{ $project->name }}</h1>
                <p class="mt-2 text-sm text-slate-500">{{ $project->website_url ?: 'No website URL saved yet.' }}</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('reports.create', ['project' => $project->id]) }}" wire:navigate class="rounded-md bg-neutral-800 px-4 py-2 text-sm font-bold text-white hover:bg-neutral-700">New Report</a>
                <a href="{{ route('projects.edit', $project) }}" wire:navigate class="rounded-md border border-slate-200 bg-white px-4 py-2 text-sm font-bold text-slate-700 hover:bg-slate-50">Edit Project</a>
            </div>
        </div>
    </x-slot>

    <div class="bg-slate-100 py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <section class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm shadow-slate-200/60">
                    <p class="text-sm font-medium text-slate-500">Status</p>
                    <p class="mt-3 text-2xl font-bold text-slate-950">{{ ucfirst($project->status) }}</p>
                </section>

                <section class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm shadow-slate-200/60">
                    <p class="text-sm font-medium text-slate-500">Projektart</p>
                    <p class="mt-3 text-2xl font-bold text-slate-950">{{ ucfirst($project->type) }}</p>
                </section>

                <section class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm shadow-slate-200/60">
                    <p class="text-sm font-medium text-slate-500">Zuständig</p>
                    <p class="mt-3 text-2xl font-bold text-slate-950">{{ $project->assignedUser?->name ?: '-' }}</p>
                </section>

                <section class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm shadow-slate-200/60">
                    <p class="text-sm font-medium text-slate-500">Wartung</p>
                    <p class="mt-3 text-2xl font-bold text-slate-950">{{ $project->maintenance_package ?: ($project->monthly_price ? '€'.$project->monthly_price : '-') }}</p>
                </section>
            </div>

            <div class="grid gap-6 xl:grid-cols-[1fr_360px]">
                <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm shadow-slate-200/60">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold text-slate-950">Project Workspace</h2>
                        <span class="rounded-full bg-neutral-100 px-3 py-1 text-xs font-bold text-neutral-700">Project folders</span>
                    </div>

                    <div class="mt-6 grid gap-4 md:grid-cols-2">
                        @foreach ($folderSections as $section)
                            <div class="rounded-lg border border-slate-200 p-5">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <h3 class="font-bold text-slate-950">{{ $section['title'] }}</h3>
                                        <p class="mt-2 text-sm leading-6 text-slate-500">{{ $section['description'] }}</p>
                                    </div>
                                    <span class="shrink-0 rounded-md bg-slate-100 px-2 py-1 text-xs font-bold text-slate-600">{{ $section['status'] }}</span>
                                </div>

                                <div class="mt-5">
                                    @if ($section['url'])
                                        <a href="{{ $section['url'] }}" @if (str_starts_with($section['url'], 'http')) target="_blank" rel="noreferrer" @else wire:navigate @endif class="inline-flex rounded-md bg-neutral-800 px-3 py-2 text-sm font-bold text-white hover:bg-neutral-700">
                                            Open
                                        </a>
                                    @else
                                        <span class="inline-flex rounded-md border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-500">Coming later</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>

                <aside class="space-y-6">
                    <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm shadow-slate-200/60">
                        <h2 class="text-lg font-bold text-slate-950">Setup</h2>
                        <dl class="mt-5 space-y-4 text-sm">
                            <div><dt class="text-slate-500">CMS / System</dt><dd class="font-semibold text-slate-900">{{ $project->cms ?: '-' }}</dd></div>
                            <div><dt class="text-slate-500">Theme / Builder</dt><dd class="font-semibold text-slate-900">{{ $project->theme_builder ?: '-' }}</dd></div>
                            <div><dt class="text-slate-500">Hosting</dt><dd class="font-semibold text-slate-900">{{ $project->hosting ?: '-' }}</dd></div>
                            <div><dt class="text-slate-500">Domain-Registrar</dt><dd class="font-semibold text-slate-900">{{ $project->domain_registrar ?: '-' }}</dd></div>
                        </dl>
                    </section>

                    <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm shadow-slate-200/60">
                        <h2 class="text-lg font-bold text-slate-950">Requirements</h2>
                        <p class="mt-4 whitespace-pre-line text-sm leading-6 text-slate-600">{{ $project->requirements ?: 'No project requirements saved yet.' }}</p>
                    </section>
                </aside>
            </div>

            <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm shadow-slate-200/60">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-slate-950">Individual Maintenance Reports</h2>
                    <a href="{{ route('reports.create', ['project' => $project->id]) }}" wire:navigate class="text-sm font-bold text-neutral-700">Create Report</a>
                </div>

                <div class="mt-5 divide-y divide-slate-100">
                    @forelse ($project->maintenanceReports as $report)
                        <a href="{{ route('reports.show', $report) }}" wire:navigate class="block py-4">
                            <p class="font-bold text-slate-950">Wartungsbericht {{ $report->period_to?->format('m/Y') ?: $report->created_at->format('m/Y') }}</p>
                            <p class="mt-1 text-sm text-slate-500">{{ ucfirst($report->status) }} · {{ $report->total_hours }} Std.</p>
                        </a>
                    @empty
                        <p class="py-8 text-sm text-slate-500">No reports yet. Create the first monthly report for this project.</p>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
