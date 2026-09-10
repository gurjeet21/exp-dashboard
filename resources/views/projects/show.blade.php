@php
    $categoryLabels = \App\Models\ProjectFile::CATEGORIES;
    $filesByCategory = $project->files->groupBy('category');
    $fileSize = function (int $bytes): string {
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 1).' MB';
        }

        return max(1, (int) ceil($bytes / 1024)).' KB';
    };

    $folderSections = [
        [
            'title' => 'Project Documents',
            'description' => 'Website content, legal PDFs, contracts, approvals and briefing files.',
            'category' => 'documents',
            'status' => ($filesByCategory->get('documents')?->count() ?? 0).' files',
        ],
        [
            'title' => 'Project Related Images',
            'description' => 'Logos, banners, screenshots, image material and design assets.',
            'category' => 'images',
            'status' => ($filesByCategory->get('images')?->count() ?? 0).' files',
        ],
        [
            'title' => 'Maintenance Reports',
            'description' => 'Monthly reports for this project with tasks, hours, PDF and email workflow.',
            'category' => 'maintenance_reports',
            'status' => $project->maintenanceReports->count().' reports',
        ],
        [
            'title' => 'Tasks / Control Center',
            'description' => 'Internal tasks, client-visible tasks, developer, dates, status and hours.',
            'category' => null,
            'status' => 'Planned',
        ],
        [
            'title' => 'Tresor / Zugangsdaten',
            'description' => 'Hosting, CMS, FTP, email, API keys and protected project access data.',
            'category' => 'access',
            'status' => ($filesByCategory->get('access')?->count() ?? 0).' files',
        ],
        [
            'title' => 'Tickets',
            'description' => 'Client issues and requests that can later be assigned to your team.',
            'category' => null,
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
            @if (session('status'))
                <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">
                    {{ session('status') }}
                </div>
            @endif

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
                    <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                        <div>
                            <h2 class="text-xl font-bold text-slate-950">Project Workspace</h2>
                            <p class="mt-1 text-sm text-slate-500">Upload documents, images and internal project files directly into eXP Dashboard.</p>
                        </div>
                        <span class="w-fit rounded-full bg-neutral-100 px-3 py-1 text-xs font-bold text-neutral-700">Portal storage</span>
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
                                    @if ($section['category'])
                                        <span class="inline-flex rounded-md bg-neutral-800 px-3 py-2 text-sm font-bold text-white">Ready</span>
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
                        <h2 class="text-lg font-bold text-slate-950">Upload File</h2>
                        <form method="POST" action="{{ route('projects.files.store', $project) }}" enctype="multipart/form-data" class="mt-5 space-y-4">
                            @csrf
                            <input type="hidden" name="entry_type" value="file">

                            <div>
                                <x-input-label for="file" value="File" />
                                <input id="file" name="file" type="file" class="mt-1 block w-full rounded-md border border-gray-300 bg-white text-sm text-slate-700 file:mr-4 file:border-0 file:bg-neutral-800 file:px-4 file:py-2 file:text-sm file:font-bold file:text-white" required>
                                <p class="mt-2 text-xs text-slate-500">Current local upload limit: 2 MB. Larger files need a PHP/server upload limit change.</p>
                                <x-input-error :messages="$errors->get('file')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="category" value="Category" />
                                <select id="category" name="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    @foreach ($categoryLabels as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <x-input-label for="visibility" value="Visibility" />
                                <select id="visibility" name="visibility" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="internal">Internal only</option>
                                    <option value="client">Client visible</option>
                                </select>
                            </div>

                            <div>
                                <x-input-label for="notes" value="Notes" />
                                <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                            </div>

                            <x-primary-button>Upload</x-primary-button>
                        </form>
                    </section>

                    <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm shadow-slate-200/60">
                        <h2 class="text-lg font-bold text-slate-950">Write Detail</h2>
                        <form method="POST" action="{{ route('projects.files.store', $project) }}" class="mt-5 space-y-4">
                            @csrf
                            <input type="hidden" name="entry_type" value="note">

                            <div>
                                <x-input-label for="note_title" value="Title" />
                                <x-text-input id="note_title" name="title" class="mt-1 block w-full" value="{{ old('entry_type') === 'note' ? old('title') : '' }}" placeholder="Hosting note, client instruction..." />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="note_category" value="Category" />
                                <select id="note_category" name="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    @foreach ($categoryLabels as $value => $label)
                                        <option value="{{ $value }}" @selected(old('entry_type') === 'note' && old('category') === $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <x-input-label for="note_visibility" value="Visibility" />
                                <select id="note_visibility" name="visibility" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="internal" @selected(old('entry_type') === 'note' && old('visibility') === 'internal')>Internal only</option>
                                    <option value="client" @selected(old('entry_type') === 'note' && old('visibility') === 'client')>Client visible</option>
                                </select>
                            </div>

                            <div>
                                <x-input-label for="note_content" value="Details" />
                                <textarea id="note_content" name="content" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Write details here...">{{ old('entry_type') === 'note' ? old('content') : '' }}</textarea>
                                <x-input-error :messages="$errors->get('content')" class="mt-2" />
                            </div>

                            <x-primary-button>Save Detail</x-primary-button>
                        </form>
                    </section>

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
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-slate-950">Project Files</h2>
                        <p class="mt-1 text-sm text-slate-500">Files are stored privately and can only be downloaded through the portal.</p>
                    </div>
                    <span class="w-fit rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600">{{ $project->files->count() }} total</span>
                </div>

                <div class="mt-5 divide-y divide-slate-100">
                    @forelse ($project->files as $file)
                        <div class="grid gap-4 py-4 lg:grid-cols-[1fr_auto] lg:items-center">
                            <div>
                                <div class="flex flex-wrap items-center gap-2">
                                    <p class="font-bold text-slate-950">{{ $file->title ?: $file->original_name }}</p>
                                    <span @class([
                                        'rounded-md px-2 py-1 text-xs font-bold',
                                        'bg-slate-100 text-slate-600' => $file->entry_type === 'file',
                                        'bg-sky-50 text-sky-700' => $file->entry_type === 'note',
                                    ])>{{ $file->entry_type === 'note' ? 'Written detail' : 'File' }}</span>
                                    <span class="rounded-md bg-slate-100 px-2 py-1 text-xs font-bold text-slate-600">{{ $categoryLabels[$file->category] ?? ucfirst($file->category) }}</span>
                                    <span @class([
                                        'rounded-md px-2 py-1 text-xs font-bold',
                                        'bg-emerald-50 text-emerald-700' => $file->visibility === 'client',
                                        'bg-rose-50 text-rose-700' => $file->visibility !== 'client',
                                    ])>{{ $file->visibility === 'client' ? 'Client visible' : 'Internal only' }}</span>
                                </div>
                                <p class="mt-1 text-sm text-slate-500">
                                    @if ($file->entry_type === 'file')
                                        {{ $fileSize((int) $file->size) }} ·
                                    @endif
                                    Saved by {{ $file->uploader?->name ?: 'Unknown' }} · {{ $file->created_at->format('d.m.Y H:i') }}
                                </p>
                                @if ($file->content)
                                    <p class="mt-2 whitespace-pre-line rounded-md bg-slate-50 p-3 text-sm leading-6 text-slate-700">{{ $file->content }}</p>
                                @endif
                                @if ($file->notes)
                                    <p class="mt-2 text-sm text-slate-600">{{ $file->notes }}</p>
                                @endif
                            </div>

                            <div class="flex flex-wrap gap-2">
                                @if ($file->entry_type === 'file')
                                    <a href="{{ route('project-files.download', $file) }}" class="rounded-md bg-neutral-800 px-3 py-2 text-sm font-bold text-white hover:bg-neutral-700">Download</a>
                                @endif
                                <form method="POST" action="{{ route('project-files.destroy', $file) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-md border border-rose-200 bg-white px-3 py-2 text-sm font-bold text-rose-700 hover:bg-rose-50">Delete</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="py-8 text-sm text-slate-500">No files uploaded yet.</p>
                    @endforelse
                </div>
            </section>

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
