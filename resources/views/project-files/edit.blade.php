@php
    $categoryLabels = \App\Models\ProjectFile::CATEGORIES;
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold text-slate-500">{{ $projectFile->project->client->company_name }} · {{ $projectFile->project->name }}</p>
                <h1 class="mt-2 text-3xl font-bold text-slate-950">Edit Project Item</h1>
            </div>
            <a href="{{ route('projects.show', $projectFile->project) }}" wire:navigate class="rounded-md border border-slate-200 bg-white px-4 py-2 text-sm font-bold text-slate-700 hover:bg-slate-50">Back to Project</a>
        </div>
    </x-slot>

    <div class="bg-slate-100 py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('project-files.update', $projectFile) }}" class="space-y-6 rounded-lg border border-slate-200 bg-white p-6 shadow-sm shadow-slate-200/60">
                @csrf
                @method('PUT')

                <div>
                    <x-input-label for="title" value="Title" />
                    <x-text-input id="title" name="title" class="mt-1 block w-full" value="{{ old('title', $projectFile->title ?: $projectFile->original_name) }}" />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <x-input-label for="category" value="Category" />
                        <select id="category" name="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @foreach ($categoryLabels as $value => $label)
                                <option value="{{ $value }}" @selected(old('category', $projectFile->category) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input-label for="visibility" value="Visibility" />
                        <select id="visibility" name="visibility" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="internal" @selected(old('visibility', $projectFile->visibility) === 'internal')>Internal only</option>
                            <option value="client" @selected(old('visibility', $projectFile->visibility) === 'client')>Client visible</option>
                        </select>
                    </div>
                </div>

                @if ($projectFile->entry_type === 'note')
                    <div>
                        <x-input-label for="content" value="Details" />
                        <textarea id="content" name="content" rows="8" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('content', $projectFile->content) }}</textarea>
                        <x-input-error :messages="$errors->get('content')" class="mt-2" />
                    </div>
                @else
                    <div class="rounded-lg bg-slate-50 p-4 text-sm text-slate-600">
                        File replacement will be added later. For now you can edit metadata, or delete and upload the file again.
                    </div>
                @endif

                <div>
                    <x-input-label for="notes" value="Notes" />
                    <textarea id="notes" name="notes" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('notes', $projectFile->notes) }}</textarea>
                    <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('projects.show', $projectFile->project) }}" wire:navigate class="rounded-md border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700">Cancel</a>
                    <x-primary-button>Save Changes</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
