@php
    $profile = $client->profile;
    $list = fn ($items) => collect($items ?? [])->filter();
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Kundenprofil {{ $profile?->short_code }}</p>
                <h1 class="mt-1 text-2xl font-semibold text-gray-950">{{ $client->company_name }}</h1>
            </div>
            <a href="{{ route('clients.edit', $client) }}" wire:navigate class="rounded-md border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-700">Edit Profile</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <div class="grid gap-6 lg:grid-cols-3">
                <section class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                    <h2 class="text-base font-semibold text-gray-950">Stammdaten</h2>
                    <dl class="mt-4 space-y-3 text-sm">
                        <div><dt class="text-gray-500">Branche</dt><dd class="font-medium text-gray-900">{{ $profile?->industry ?: '-' }}</dd></div>
                        <div><dt class="text-gray-500">Rechtsform</dt><dd class="font-medium text-gray-900">{{ $profile?->legal_form ?: '-' }}</dd></div>
                        <div><dt class="text-gray-500">Kunde seit</dt><dd class="font-medium text-gray-900">{{ $profile?->customer_since ?: '-' }}</dd></div>
                        <div><dt class="text-gray-500">Kundenwert</dt><dd class="font-medium text-gray-900">{{ $profile?->customer_value ?: '-' }}</dd></div>
                    </dl>
                </section>

                <section class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                    <h2 class="text-base font-semibold text-gray-950">Kommunikation</h2>
                    <dl class="mt-4 space-y-3 text-sm">
                        <div><dt class="text-gray-500">Hauptkontakt</dt><dd class="font-medium text-gray-900">{{ $client->contact_name ?: '-' }}</dd></div>
                        <div><dt class="text-gray-500">E-Mail</dt><dd class="font-medium text-gray-900">{{ $client->email ?: '-' }}</dd></div>
                        <div><dt class="text-gray-500">Telefon</dt><dd class="font-medium text-gray-900">{{ $client->phone ?: '-' }}</dd></div>
                        <div><dt class="text-gray-500">Kanal</dt><dd class="font-medium text-gray-900">{{ $profile?->preferred_channel ?: '-' }}</dd></div>
                    </dl>
                </section>

                <section class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                    <h2 class="text-base font-semibold text-gray-950">Technik</h2>
                    <dl class="mt-4 space-y-3 text-sm">
                        <div><dt class="text-gray-500">CMS</dt><dd class="font-medium text-gray-900">{{ $profile?->cms ?: '-' }}</dd></div>
                        <div><dt class="text-gray-500">Theme / Builder</dt><dd class="font-medium text-gray-900">{{ $profile?->theme_builder ?: '-' }}</dd></div>
                        <div><dt class="text-gray-500">Hosting</dt><dd class="font-medium text-gray-900">{{ $profile?->hosting ?: '-' }}</dd></div>
                        <div><dt class="text-gray-500">SSL</dt><dd class="font-medium text-gray-900">{{ $profile?->ssl_certificate ?: '-' }}</dd></div>
                    </dl>
                </section>
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                <section class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                    <h2 class="text-base font-semibold text-gray-950">Leistungen</h2>
                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <div>
                            <p class="text-sm font-semibold text-gray-700">Aktiv</p>
                            <div class="mt-2 flex flex-wrap gap-2">@forelse ($list($profile?->services_active) as $item)<span class="rounded-md bg-emerald-50 px-2 py-1 text-xs font-semibold text-emerald-700">{{ $item }}</span>@empty<span class="text-sm text-gray-500">-</span>@endforelse</div>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-700">Potenzial</p>
                            <div class="mt-2 flex flex-wrap gap-2">@forelse ($list($profile?->services_potential) as $item)<span class="rounded-md bg-sky-50 px-2 py-1 text-xs font-semibold text-sky-700">{{ $item }}</span>@empty<span class="text-sm text-gray-500">-</span>@endforelse</div>
                        </div>
                    </div>
                </section>

                <section class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                    <h2 class="text-base font-semibold text-gray-950">SEO Quick-Check</h2>
                    <div class="mt-4 flex flex-wrap gap-2">@forelse ($list($profile?->seo_checks) as $item)<span class="rounded-md bg-gray-100 px-2 py-1 text-xs font-semibold text-gray-700">{{ $item }}</span>@empty<span class="text-sm text-gray-500">No SEO checks saved yet.</span>@endforelse</div>
                    <p class="mt-4 text-sm text-gray-600">{{ $profile?->seo_notes }}</p>
                </section>
            </div>

            <div class="grid gap-6 lg:grid-cols-3">
                <section class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm lg:col-span-2">
                    <div class="flex items-center justify-between">
                        <h2 class="text-base font-semibold text-gray-950">Projects</h2>
                        <a href="{{ route('projects.create', ['client' => $client->id]) }}" wire:navigate class="text-sm font-semibold text-gray-900">Add Project</a>
                    </div>
                    <div class="mt-4 divide-y divide-gray-100">
                        @forelse ($client->projects as $project)
                            <a href="{{ route('projects.show', $project) }}" wire:navigate class="block py-3">
                                <p class="font-semibold text-gray-950">{{ $project->name }}</p>
                                <p class="text-sm text-gray-500">{{ $project->website_url ?: 'No website URL' }}</p>
                            </a>
                        @empty
                            <p class="py-8 text-sm text-gray-500">No projects yet.</p>
                        @endforelse
                    </div>
                </section>

                <section class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                    <h2 class="text-base font-semibold text-gray-950">Interne Notizen</h2>
                    <dl class="mt-4 space-y-3 text-sm">
                        <div><dt class="text-gray-500">Zuständig</dt><dd class="font-medium text-gray-900">{{ $profile?->internal_owner ?: '-' }}</dd></div>
                        <div><dt class="text-gray-500">Zufriedenheit</dt><dd class="font-medium text-gray-900">{{ $profile?->satisfaction ?: '-' }}</dd></div>
                        <div><dt class="text-gray-500">Zahlungsverhalten</dt><dd class="font-medium text-gray-900">{{ $profile?->payment_behavior ?: '-' }}</dd></div>
                    </dl>
                    @if ($profile?->personal_notes)
                        <p class="mt-4 rounded-md bg-gray-50 p-3 text-sm text-gray-700">{{ $profile->personal_notes }}</p>
                    @endif
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
