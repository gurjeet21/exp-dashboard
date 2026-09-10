@php
    $profile = $client->profile;
    $list = fn ($items) => collect($items ?? [])->filter();
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold text-slate-500">Kunde {{ $profile?->short_code }}</p>
                <h1 class="mt-2 text-3xl font-bold text-slate-950">{{ $client->company_name }}</h1>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('projects.create', ['client' => $client->id]) }}" wire:navigate class="rounded-md bg-neutral-800 px-4 py-2 text-sm font-bold text-white hover:bg-neutral-700">Add Project</a>
                <a href="{{ route('clients.edit', $client) }}" wire:navigate class="rounded-md border border-slate-200 bg-white px-4 py-2 text-sm font-bold text-slate-700 hover:bg-slate-50">Edit Client</a>
            </div>
        </div>
    </x-slot>

    <div class="bg-slate-100 py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <div class="grid gap-6 lg:grid-cols-3">
                <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm shadow-slate-200/60">
                    <h2 class="text-lg font-bold text-slate-950">Stammdaten</h2>
                    <dl class="mt-5 space-y-4 text-sm">
                        <div><dt class="text-slate-500">Branche</dt><dd class="font-semibold text-slate-900">{{ $profile?->industry ?: '-' }}</dd></div>
                        <div><dt class="text-slate-500">Rechtsform</dt><dd class="font-semibold text-slate-900">{{ $profile?->legal_form ?: '-' }}</dd></div>
                        <div><dt class="text-slate-500">Kunde seit</dt><dd class="font-semibold text-slate-900">{{ $profile?->customer_since ?: '-' }}</dd></div>
                        <div><dt class="text-slate-500">Status</dt><dd class="font-semibold text-slate-900">{{ ucfirst($client->status) }}</dd></div>
                    </dl>
                </section>

                <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm shadow-slate-200/60">
                    <h2 class="text-lg font-bold text-slate-950">Kontakt</h2>
                    <dl class="mt-5 space-y-4 text-sm">
                        <div><dt class="text-slate-500">Hauptkontakt</dt><dd class="font-semibold text-slate-900">{{ $client->contact_name ?: '-' }}</dd></div>
                        <div><dt class="text-slate-500">E-Mail</dt><dd class="font-semibold text-slate-900">{{ $client->email ?: '-' }}</dd></div>
                        <div><dt class="text-slate-500">Telefon</dt><dd class="font-semibold text-slate-900">{{ $client->phone ?: '-' }}</dd></div>
                        <div><dt class="text-slate-500">Kontaktweg</dt><dd class="font-semibold text-slate-900">{{ $profile?->preferred_channel ?: '-' }}</dd></div>
                    </dl>
                </section>

                <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm shadow-slate-200/60">
                    <h2 class="text-lg font-bold text-slate-950">Weitere Kontakte</h2>
                    <div class="mt-5 space-y-4 text-sm">
                        <div>
                            <p class="text-slate-500">Weitere E-Mails</p>
                            <div class="mt-2 space-y-1">
                                @forelse ($list($profile?->emails) as $email)
                                    <p class="font-semibold text-slate-900">{{ $email }}</p>
                                @empty
                                    <p class="text-slate-500">-</p>
                                @endforelse
                            </div>
                        </div>
                        <div>
                            <p class="text-slate-500">Weitere Telefonnummern</p>
                            <div class="mt-2 space-y-1">
                                @forelse ($list($profile?->phones) as $phone)
                                    <p class="font-semibold text-slate-900">{{ $phone }}</p>
                                @empty
                                    <p class="text-slate-500">-</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <div class="grid gap-6 lg:grid-cols-[1fr_360px]">
                <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm shadow-slate-200/60">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-xl font-bold text-slate-950">Projects</h2>
                            <p class="mt-1 text-sm text-slate-500">All project-level work, reports, documents and tickets live inside these projects.</p>
                        </div>
                        <a href="{{ route('projects.create', ['client' => $client->id]) }}" wire:navigate class="text-sm font-bold text-neutral-700">Add Project</a>
                    </div>

                    <div class="mt-5 divide-y divide-slate-100">
                        @forelse ($client->projects as $project)
                            <a href="{{ route('projects.show', $project) }}" wire:navigate class="block py-4">
                                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                                    <div>
                                        <p class="font-bold text-slate-950">{{ $project->name }}</p>
                                        <p class="mt-1 text-sm text-slate-500">{{ $project->website_url ?: 'No website URL' }}</p>
                                    </div>
                                    <span class="w-fit rounded-md bg-slate-100 px-2.5 py-1 text-xs font-bold text-slate-600">{{ ucfirst($project->status) }}</span>
                                </div>
                            </a>
                        @empty
                            <p class="py-8 text-sm text-slate-500">No projects yet. Add the first project for this client.</p>
                        @endforelse
                    </div>
                </section>

                <aside class="space-y-6">
                    <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm shadow-slate-200/60">
                        <h2 class="text-lg font-bold text-slate-950">Adresse</h2>
                        <p class="mt-4 whitespace-pre-line text-sm leading-6 text-slate-600">{{ $client->address ?: '-' }}</p>
                    </section>

                    <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm shadow-slate-200/60">
                        <h2 class="text-lg font-bold text-slate-950">Interne Notizen</h2>
                        <p class="mt-4 whitespace-pre-line text-sm leading-6 text-slate-600">{{ $profile?->personal_notes ?: 'No internal notes saved yet.' }}</p>
                    </section>
                </aside>
            </div>
        </div>
    </div>
</x-app-layout>
