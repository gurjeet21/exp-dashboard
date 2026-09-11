@php
    $categoryLabels = collect(array_keys(\App\Models\ProjectFile::CATEGORIES))
        ->mapWithKeys(fn (string $key): array => [$key => __('project_files.categories.'.$key)])
        ->all();
    $filesByCategory = $project->files->groupBy('category');
    $fileSize = function (int $bytes): string {
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 1).' MB';
        }

        return max(1, (int) ceil($bytes / 1024)).' KB';
    };

    $folderSections = [
        [
            'title' => __('project_files.categories.documents'),
            'description' => __('project_files.category_descriptions.documents'),
            'category' => 'documents',
            'anchor' => 'project-files-documents',
            'status' => trans_choice('project_files.files_count', $filesByCategory->get('documents')?->count() ?? 0),
        ],
        [
            'title' => __('project_files.categories.images'),
            'description' => __('project_files.category_descriptions.images'),
            'category' => 'images',
            'anchor' => 'project-files-images',
            'status' => trans_choice('project_files.files_count', $filesByCategory->get('images')?->count() ?? 0),
        ],
        [
            'title' => __('project_files.categories.maintenance_reports'),
            'description' => __('project_files.category_descriptions.maintenance_reports'),
            'category' => 'maintenance_reports',
            'anchor' => 'project-files-maintenance_reports',
            'status' => trans_choice('project_files.reports_count', $project->maintenanceReports->count()),
        ],
        [
            'title' => __('project_files.labels.tasks_control_center'),
            'description' => __('project_files.category_descriptions.tasks'),
            'category' => null,
            'anchor' => null,
            'status' => __('project_files.labels.planned'),
        ],
        [
            'title' => __('project_files.categories.access'),
            'description' => __('project_files.category_descriptions.access'),
            'category' => 'access',
            'anchor' => 'project-files-access',
            'status' => trans_choice('project_files.files_count', $filesByCategory->get('access')?->count() ?? 0),
        ],
        [
            'title' => __('app.nav.tickets'),
            'description' => __('project_files.category_descriptions.tickets'),
            'category' => null,
            'anchor' => null,
            'status' => __('project_files.labels.planned'),
        ],
    ];
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold text-slate-500">{{ $project->client->company_name }}</p>
                <h1 class="mt-2 text-3xl font-bold text-slate-950">{{ $project->name }}</h1>
                <p class="mt-2 text-sm text-slate-500">{{ $project->website_url ?: __('project_files.labels.no_website_url') }}</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('reports.create', ['project' => $project->id]) }}" wire:navigate class="rounded-md bg-neutral-800 px-4 py-2 text-sm font-bold text-white hover:bg-neutral-700">{{ __('project_files.actions.new_report') }}</a>
                <a href="{{ route('projects.edit', $project) }}" wire:navigate class="rounded-md border border-slate-200 bg-white px-4 py-2 text-sm font-bold text-slate-700 hover:bg-slate-50">{{ __('project_files.actions.edit_project') }}</a>
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
                    <p class="mt-3 text-2xl font-bold text-slate-950">{{ __('project_files.status.'.$project->status) }}</p>
                </section>

                <section class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm shadow-slate-200/60">
                    <p class="text-sm font-medium text-slate-500">Projektart</p>
                    <p class="mt-3 text-2xl font-bold text-slate-950">{{ __('project_files.types.'.$project->type) }}</p>
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
                            <h2 class="text-xl font-bold text-slate-950">{{ __('project_files.labels.project_workspace') }}</h2>
                            <p class="mt-1 text-sm text-slate-500">{{ __('project_files.labels.workspace_description') }}</p>
                        </div>
                        <span class="w-fit rounded-full bg-neutral-100 px-3 py-1 text-xs font-bold text-neutral-700">{{ __('project_files.labels.portal_storage') }}</span>
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
                                        <a href="#{{ $section['anchor'] }}" class="inline-flex rounded-md bg-neutral-800 px-3 py-2 text-sm font-bold text-white hover:bg-neutral-700">{{ __('project_files.actions.view_items') }}</a>
                                    @else
                                        <span class="inline-flex rounded-md border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-500">{{ __('project_files.actions.coming_later') }}</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>

                <aside class="space-y-6">
                    <section id="file-upload-panel" class="scroll-mt-6 rounded-lg border border-slate-200 bg-white p-6 shadow-sm shadow-slate-200/60">
                        <h2 class="text-lg font-bold text-slate-950">{{ __('project_files.labels.upload_file') }}</h2>
                        <form method="POST" action="{{ route('projects.files.store', $project) }}" enctype="multipart/form-data" class="mt-5 space-y-4">
                            @csrf
                            <input type="hidden" name="entry_type" value="file">

                            <div>
                                <x-input-label for="file" :value="__('project_files.fields.file')" />
                                <input id="file" name="file" type="file" class="mt-1 block w-full rounded-md border border-gray-300 bg-white text-sm text-slate-700 file:mr-4 file:border-0 file:bg-neutral-800 file:px-4 file:py-2 file:text-sm file:font-bold file:text-white" required>
                                <p class="mt-2 text-xs text-slate-500">{{ __('project_files.labels.upload_limit') }}</p>
                                <x-input-error :messages="$errors->get('file')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="category" :value="__('project_files.fields.category')" />
                                <select id="category" name="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    @foreach ($categoryLabels as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <x-input-label for="visibility" :value="__('project_files.fields.visibility')" />
                                <select id="visibility" name="visibility" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="internal">{{ __('project_files.labels.internal_only') }}</option>
                                    <option value="client">{{ __('project_files.labels.client_visible') }}</option>
                                </select>
                            </div>

                            <div>
                                <x-input-label for="notes" :value="__('project_files.fields.notes')" />
                                <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                            </div>

                            <x-primary-button>{{ __('project_files.actions.upload') }}</x-primary-button>
                        </form>
                    </section>

                    <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm shadow-slate-200/60">
                        <h2 class="text-lg font-bold text-slate-950">{{ __('project_files.labels.write_detail') }}</h2>
                        <form method="POST" action="{{ route('projects.files.store', $project) }}" class="mt-5 space-y-4">
                            @csrf
                            <input type="hidden" name="entry_type" value="note">

                            <div>
                                <x-input-label for="note_title" :value="__('project_files.fields.title')" />
                                <x-text-input id="note_title" name="title" class="mt-1 block w-full" value="{{ old('entry_type') === 'note' ? old('title') : '' }}" :placeholder="__('project_files.placeholders.note_title')" />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="note_category" :value="__('project_files.fields.category')" />
                                <select id="note_category" name="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    @foreach ($categoryLabels as $value => $label)
                                        <option value="{{ $value }}" @selected(old('entry_type') === 'note' && old('category') === $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <x-input-label for="note_visibility" :value="__('project_files.fields.visibility')" />
                                <select id="note_visibility" name="visibility" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="internal" @selected(old('entry_type') === 'note' && old('visibility') === 'internal')>{{ __('project_files.labels.internal_only') }}</option>
                                    <option value="client" @selected(old('entry_type') === 'note' && old('visibility') === 'client')>{{ __('project_files.labels.client_visible') }}</option>
                                </select>
                            </div>

                            <div>
                                <x-input-label for="note_content" :value="__('project_files.fields.details')" />
                                <textarea id="note_content" name="content" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="{{ __('project_files.placeholders.note_content') }}">{{ old('entry_type') === 'note' ? old('content') : '' }}</textarea>
                                <x-input-error :messages="$errors->get('content')" class="mt-2" />
                            </div>

                            <x-primary-button>{{ __('project_files.actions.save_detail') }}</x-primary-button>
                        </form>
                    </section>

                    <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm shadow-slate-200/60">
                        <h2 class="text-lg font-bold text-slate-950">{{ __('project_files.labels.setup') }}</h2>
                        <dl class="mt-5 space-y-4 text-sm">
                            <div><dt class="text-slate-500">CMS / System</dt><dd class="font-semibold text-slate-900">{{ $project->cms ?: '-' }}</dd></div>
                            <div><dt class="text-slate-500">Theme / Builder</dt><dd class="font-semibold text-slate-900">{{ $project->theme_builder ?: '-' }}</dd></div>
                            <div><dt class="text-slate-500">Hosting</dt><dd class="font-semibold text-slate-900">{{ $project->hosting ?: '-' }}</dd></div>
                            <div><dt class="text-slate-500">Domain-Registrar</dt><dd class="font-semibold text-slate-900">{{ $project->domain_registrar ?: '-' }}</dd></div>
                        </dl>
                    </section>

                    <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm shadow-slate-200/60">
                        <h2 class="text-lg font-bold text-slate-950">{{ __('project_files.labels.requirements') }}</h2>
                        <p class="mt-4 whitespace-pre-line text-sm leading-6 text-slate-600">{{ $project->requirements ?: __('project_files.labels.no_requirements') }}</p>
                    </section>
                </aside>
            </div>

            <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm shadow-slate-200/60">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-slate-950">{{ __('project_files.labels.project_files') }}</h2>
                        <p class="mt-1 text-sm text-slate-500">{{ __('project_files.labels.files_stored_private') }}</p>
                    </div>
                    <span class="w-fit rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600">{{ trans_choice('project_files.total_count', $project->files->count()) }}</span>
                </div>

                <div class="mt-6 space-y-8">
                    @foreach ($categoryLabels as $category => $label)
                        @php $categoryFiles = $filesByCategory->get($category, collect()); @endphp
                        <div id="project-files-{{ $category }}" class="scroll-mt-6 rounded-lg border border-slate-200">
                            <div class="flex flex-col gap-2 border-b border-slate-100 bg-slate-50 px-4 py-3 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <h3 class="font-bold text-slate-950">{{ $label }}</h3>
                                    <p class="text-sm text-slate-500">{{ trans_choice('project_files.items_count', $categoryFiles->count()) }}</p>
                                </div>
                                <a href="#file-upload-panel" class="text-sm font-bold text-neutral-700">{{ __('project_files.actions.add_item') }}</a>
                            </div>

                            <div class="divide-y divide-slate-100 px-4">
                                @forelse ($categoryFiles as $file)
                                    <div class="grid gap-4 py-4 lg:grid-cols-[1fr_auto] lg:items-center">
                                        <div>
                                            <div class="flex flex-wrap items-center gap-2">
                                                <p class="font-bold text-slate-950">{{ $file->title ?: $file->original_name }}</p>
                                                <span @class([
                                                    'rounded-md px-2 py-1 text-xs font-bold',
                                                    'bg-slate-100 text-slate-600' => $file->entry_type === 'file',
                                                    'bg-sky-50 text-sky-700' => $file->entry_type === 'note',
                                                ])>{{ $file->entry_type === 'note' ? __('project_files.labels.written_detail') : __('project_files.labels.file') }}</span>
                                                <span @class([
                                                    'rounded-md px-2 py-1 text-xs font-bold',
                                                    'bg-emerald-50 text-emerald-700' => $file->visibility === 'client',
                                                    'bg-rose-50 text-rose-700' => $file->visibility !== 'client',
                                                ])>{{ $file->visibility === 'client' ? __('project_files.labels.client_visible') : __('project_files.labels.internal_only') }}</span>
                                            </div>
                                            <p class="mt-1 text-sm text-slate-500">
                                                @if ($file->entry_type === 'file')
                                                    {{ $fileSize((int) $file->size) }} ·
                                                @endif
                                                {{ __('project_files.labels.saved_by') }} {{ $file->uploader?->name ?: '-' }} · {{ $file->created_at->format('d.m.Y H:i') }}
                                            </p>
                                            @if ($file->content)
                                                <p class="mt-2 whitespace-pre-line rounded-md bg-slate-50 p-3 text-sm leading-6 text-slate-700">{{ $file->content }}</p>
                                            @endif
                                            @if ($file->notes)
                                                <p class="mt-2 text-sm text-slate-600">{{ $file->notes }}</p>
                                            @endif
                                        </div>

                                        <div class="flex flex-wrap gap-2">
                                            <a href="{{ route('project-files.edit', $file) }}" wire:navigate class="rounded-md border border-slate-200 bg-white px-3 py-2 text-sm font-bold text-slate-700 hover:bg-slate-50">{{ __('project_files.actions.edit') }}</a>
                                            @if ($file->entry_type === 'file')
                                                <a href="{{ route('project-files.download', $file) }}" class="rounded-md bg-neutral-800 px-3 py-2 text-sm font-bold text-white hover:bg-neutral-700">{{ __('project_files.actions.download') }}</a>
                                            @endif
                                            <form method="POST" action="{{ route('project-files.destroy', $file) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="rounded-md border border-rose-200 bg-white px-3 py-2 text-sm font-bold text-rose-700 hover:bg-rose-50">{{ __('project_files.actions.delete') }}</button>
                                            </form>
                                        </div>
                                    </div>
                                @empty
                                    <p class="py-5 text-sm text-slate-500">{{ __('project_files.labels.no_items') }}</p>
                                @endforelse
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm shadow-slate-200/60">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-slate-950">{{ __('project_files.labels.individual_reports') }}</h2>
                    <a href="{{ route('reports.create', ['project' => $project->id]) }}" wire:navigate class="text-sm font-bold text-neutral-700">{{ __('project_files.actions.create_report') }}</a>
                </div>

                <div class="mt-5 divide-y divide-slate-100">
                    @forelse ($project->maintenanceReports as $report)
                        <a href="{{ route('reports.show', $report) }}" wire:navigate class="block py-4">
                            <p class="font-bold text-slate-950">Wartungsbericht {{ $report->period_to?->format('m/Y') ?: $report->created_at->format('m/Y') }}</p>
                            <p class="mt-1 text-sm text-slate-500">{{ ucfirst($report->status) }} · {{ $report->total_hours }} Std.</p>
                        </a>
                    @empty
                        <p class="py-8 text-sm text-slate-500">{{ __('project_files.labels.no_reports') }}</p>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
