<form method="POST" action="{{ $action }}" class="space-y-6">
    @csrf
    @if ($method !== 'POST') @method($method) @endif

    <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm shadow-slate-200/60">
        <div class="border-b border-slate-100 pb-5">
            <h2 class="text-lg font-bold text-slate-950">Projekt-Stammdaten</h2>
            <p class="mt-1 text-sm text-slate-500">Die wichtigsten Informationen, damit das Projekt sauber einem Kunden und Teammitglied zugeordnet ist.</p>
        </div>

        <div class="mt-6 grid gap-5 sm:grid-cols-2">
            <div>
                <x-input-label for="client_id" value="Kunde" />
                <select id="client_id" name="client_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    <option value="">Bitte Kunde auswählen</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}" @selected((int) old('client_id', $project->client_id) === $client->id)>{{ $client->company_name }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('client_id')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="assigned_user_id" value="Zuständig intern" />
                <select id="assigned_user_id" name="assigned_user_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">Noch nicht zugewiesen</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" @selected((int) old('assigned_user_id', $project->assigned_user_id) === $user->id)>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <x-input-label for="name" value="Projektname" />
                <x-text-input id="name" name="name" class="mt-1 block w-full" value="{{ old('name', $project->name) }}" required placeholder="Website Wartung, SEO Betreuung..." />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="website_url" value="Website URL" />
                <x-text-input id="website_url" name="website_url" class="mt-1 block w-full" value="{{ old('website_url', $project->website_url) }}" placeholder="https://example.de" />
                <x-input-error :messages="$errors->get('website_url')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="type" value="Projektart" />
                <select id="type" name="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    @foreach (['maintenance' => 'Wartung', 'website' => 'Website / Relaunch', 'shop' => 'Online Shop', 'seo' => 'SEO', 'marketing' => 'Marketing', 'development' => 'Entwicklung'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('type', $project->type ?: 'maintenance') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <x-input-label for="status" value="Status" />
                <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="active" @selected(old('status', $project->status ?: 'active') === 'active')>Aktiv</option>
                    <option value="paused" @selected(old('status', $project->status) === 'paused')>Pausiert</option>
                    <option value="completed" @selected(old('status', $project->status) === 'completed')>Abgeschlossen</option>
                </select>
            </div>

            <div>
                <x-input-label for="start_date" value="Startdatum" />
                <x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full" value="{{ old('start_date', $project->start_date?->format('Y-m-d')) }}" />
            </div>

            <div>
                <x-input-label for="monthly_price" value="Monatlicher Betrag" />
                <x-text-input id="monthly_price" name="monthly_price" type="number" step="0.01" class="mt-1 block w-full" value="{{ old('monthly_price', $project->monthly_price) }}" placeholder="0.00" />
            </div>
        </div>
    </section>

    <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm shadow-slate-200/60">
        <div class="border-b border-slate-100 pb-5">
            <h2 class="text-lg font-bold text-slate-950">Setup & Anforderungen</h2>
            <p class="mt-1 text-sm text-slate-500">Technische Details und Anforderungen, die zu diesem konkreten Projekt gehören.</p>
        </div>

        <div class="mt-6 grid gap-5 sm:grid-cols-2">
            <div>
                <x-input-label for="cms" value="CMS / System" />
                <x-text-input id="cms" name="cms" class="mt-1 block w-full" value="{{ old('cms', $project->cms) }}" placeholder="WordPress, Shopify, Laravel..." />
            </div>

            <div>
                <x-input-label for="theme_builder" value="Theme / Builder" />
                <x-text-input id="theme_builder" name="theme_builder" class="mt-1 block w-full" value="{{ old('theme_builder', $project->theme_builder) }}" placeholder="Elementor, Bricks, Custom..." />
            </div>

            <div>
                <x-input-label for="hosting" value="Hosting / Server" />
                <x-text-input id="hosting" name="hosting" class="mt-1 block w-full" value="{{ old('hosting', $project->hosting) }}" placeholder="all-inkl, Strato, Hetzner..." />
            </div>

            <div>
                <x-input-label for="domain_registrar" value="Domain-Registrar" />
                <x-text-input id="domain_registrar" name="domain_registrar" class="mt-1 block w-full" value="{{ old('domain_registrar', $project->domain_registrar) }}" />
            </div>

            <div>
                <x-input-label for="maintenance_package" value="Wartungspaket" />
                <x-text-input id="maintenance_package" name="maintenance_package" class="mt-1 block w-full" value="{{ old('maintenance_package', $project->maintenance_package) }}" placeholder="Basic, Standard, Premium..." />
            </div>
        </div>

        <div class="mt-5">
            <x-input-label for="requirements" value="Projektanforderungen" />
            <textarea id="requirements" name="requirements" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Was muss bei diesem Projekt beachtet werden?">{{ old('requirements', $project->requirements) }}</textarea>
        </div>
    </section>

    <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm shadow-slate-200/60">
        <div class="border-b border-slate-100 pb-5">
            <h2 class="text-lg font-bold text-slate-950">Projekt-Ordner</h2>
            <p class="mt-1 text-sm text-slate-500">Für den Start speichern wir Links zu bestehenden Drive/Workspace Ordnern. Später kann daraus ein eigenes Upload-Modul werden.</p>
        </div>

        <div class="mt-6 grid gap-5">
            <div>
                <x-input-label for="project_documents_url" value="Project Documents" />
                <x-text-input id="project_documents_url" name="project_documents_url" class="mt-1 block w-full" value="{{ old('project_documents_url', $project->project_documents_url) }}" placeholder="https://drive.google.com/..." />
                <x-input-error :messages="$errors->get('project_documents_url')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="project_images_url" value="Project Related Images" />
                <x-text-input id="project_images_url" name="project_images_url" class="mt-1 block w-full" value="{{ old('project_images_url', $project->project_images_url) }}" placeholder="https://drive.google.com/..." />
                <x-input-error :messages="$errors->get('project_images_url')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="access_vault_url" value="Tresor / Zugangsdaten" />
                <x-text-input id="access_vault_url" name="access_vault_url" class="mt-1 block w-full" value="{{ old('access_vault_url', $project->access_vault_url) }}" placeholder="Interner Link zum Passwortmanager oder Tresor" />
                <x-input-error :messages="$errors->get('access_vault_url')" class="mt-2" />
            </div>
        </div>
    </section>

    <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm shadow-slate-200/60">
        <x-input-label for="notes" value="Interne Projektnotizen" />
        <textarea id="notes" name="notes" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('notes', $project->notes) }}</textarea>
    </section>

    <div class="flex justify-end gap-3">
        <a href="{{ route('projects.index') }}" wire:navigate class="rounded-md border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700">Cancel</a>
        <x-primary-button>Save Project</x-primary-button>
    </div>
</form>
