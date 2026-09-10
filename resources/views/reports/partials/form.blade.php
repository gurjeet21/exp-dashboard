@php
    $statusOptions = ['ok' => 'OK', 'updated' => 'UPDATE', 'warn' => 'WARN', 'err' => 'ERROR'];
    $systemItems = old('system_items', $defaults['system_items']);
    $securityItems = old('security_items', $defaults['security_items']);
    $backupItems = old('backup_items', $defaults['backup_items']);
    $timeItems = old('time_items', $defaults['time_items']);
@endphp

<form method="POST" action="{{ $action }}" class="grid gap-6 lg:grid-cols-[420px_1fr]">
    @csrf
    @if ($method !== 'POST') @method($method) @endif

    <div class="space-y-5">
        <section class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
            <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500">Kopfdaten</h2>
            <div class="mt-4 grid gap-4">
                <div>
                    <x-input-label for="project_id" value="Projekt" />
                    <select id="project_id" name="project_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        <option value="">Projekt auswählen</option>
                        @foreach ($projects as $projectOption)
                            <option value="{{ $projectOption->id }}" @selected((int) old('project_id', $defaults['project_id']) === $projectOption->id)>{{ $projectOption->client->company_name }} · {{ $projectOption->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div><x-input-label for="period_from" value="Zeitraum von" /><x-text-input id="period_from" name="period_from" type="date" class="mt-1 block w-full" value="{{ old('period_from', $defaults['period_from']) }}" /></div>
                    <div><x-input-label for="period_to" value="Zeitraum bis" /><x-text-input id="period_to" name="period_to" type="date" class="mt-1 block w-full" value="{{ old('period_to', $defaults['period_to']) }}" /></div>
                </div>
                <div><x-input-label for="caretaker" value="Betreuer / Agentur" /><x-text-input id="caretaker" name="caretaker" class="mt-1 block w-full" value="{{ old('caretaker', $defaults['caretaker']) }}" /></div>
                <div>
                    <x-input-label for="status" value="Status" />
                    <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="draft" @selected(old('status', $defaults['status']) === 'draft')>Draft</option>
                        <option value="final" @selected(old('status', $defaults['status']) === 'final')>Final</option>
                    </select>
                </div>
            </div>
        </section>

        <section class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
            <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500">01 Systemwartung & Updates</h2>
            <div class="mt-4 space-y-4">
                @foreach ($systemItems as $i => $item)
                    <div class="rounded-md border border-gray-100 bg-gray-50 p-3">
                        <x-text-input name="system_items[{{ $i }}][component]" class="block w-full" value="{{ $item['component'] ?? '' }}" placeholder="Komponente" />
                        <div class="mt-2 grid grid-cols-[120px_1fr] gap-2">
                            <select name="system_items[{{ $i }}][status]" class="rounded-md border-gray-300 text-sm shadow-sm">@foreach ($statusOptions as $value => $label)<option value="{{ $value }}" @selected(($item['status'] ?? 'ok') === $value)>{{ $label }}</option>@endforeach</select>
                            <x-text-input name="system_items[{{ $i }}][note]" value="{{ $item['note'] ?? '' }}" placeholder="Anmerkung" />
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
            <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500">02 Sicherheit & Schutz</h2>
            <div class="mt-4 space-y-4">
                @foreach ($securityItems as $i => $item)
                    <div class="rounded-md border border-gray-100 bg-gray-50 p-3">
                        <x-text-input name="security_items[{{ $i }}][measure]" class="block w-full" value="{{ $item['measure'] ?? '' }}" placeholder="Maßnahme" />
                        <div class="mt-2 grid grid-cols-[120px_1fr] gap-2">
                            <select name="security_items[{{ $i }}][status]" class="rounded-md border-gray-300 text-sm shadow-sm">@foreach ($statusOptions as $value => $label)<option value="{{ $value }}" @selected(($item['status'] ?? 'ok') === $value)>{{ $label }}</option>@endforeach</select>
                            <x-text-input name="security_items[{{ $i }}][note]" value="{{ $item['note'] ?? '' }}" placeholder="Anmerkung" />
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>

    <div class="space-y-5">
        <section class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
            <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500">03 Backups</h2>
            <div class="mt-4 space-y-4">
                @foreach ($backupItems as $i => $item)
                    <div class="grid gap-2 rounded-md border border-gray-100 bg-gray-50 p-3 sm:grid-cols-[1fr_1fr_120px]">
                        <x-text-input name="backup_items[{{ $i }}][period]" value="{{ $item['period'] ?? '' }}" placeholder="Zeitraum" />
                        <x-text-input name="backup_items[{{ $i }}][result]" value="{{ $item['result'] ?? '' }}" placeholder="Ergebnis" />
                        <select name="backup_items[{{ $i }}][status]" class="rounded-md border-gray-300 text-sm shadow-sm">@foreach ($statusOptions as $value => $label)<option value="{{ $value }}" @selected(($item['status'] ?? 'ok') === $value)>{{ $label }}</option>@endforeach</select>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
            <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500">04 Performance & Uptime</h2>
            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                <div><x-input-label for="uptime" value="Uptime" /><x-text-input id="uptime" name="uptime" class="mt-1 block w-full" value="{{ old('uptime', $defaults['uptime']) }}" /></div>
                <div><x-input-label for="load_time" value="Ladezeit" /><x-text-input id="load_time" name="load_time" class="mt-1 block w-full" value="{{ old('load_time', $defaults['load_time']) }}" /></div>
                <div><x-input-label for="pagespeed_desktop" value="PageSpeed Desktop" /><x-text-input id="pagespeed_desktop" name="pagespeed_desktop" type="number" min="0" max="100" class="mt-1 block w-full" value="{{ old('pagespeed_desktop', $defaults['pagespeed_desktop']) }}" /></div>
                <div><x-input-label for="pagespeed_mobile" value="PageSpeed Mobil" /><x-text-input id="pagespeed_mobile" name="pagespeed_mobile" type="number" min="0" max="100" class="mt-1 block w-full" value="{{ old('pagespeed_mobile', $defaults['pagespeed_mobile']) }}" /></div>
            </div>
            <div class="mt-4"><x-input-label for="optimizations" value="Optimierungen" /><textarea id="optimizations" name="optimizations" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('optimizations', $defaults['optimizations']) }}</textarea></div>
        </section>

        <section class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
            <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500">05 Fehler & Protokolle</h2>
            <textarea name="errors" rows="4" class="mt-4 block w-full rounded-md border-gray-300 shadow-sm">{{ old('errors', $defaults['errors']) }}</textarea>
        </section>

        <section class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
            <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500">06 Wartungszeit</h2>
            <div class="mt-4 space-y-3">
                @foreach ($timeItems as $i => $item)
                    <div class="grid grid-cols-[1fr_110px] gap-2">
                        <x-text-input name="time_items[{{ $i }}][task]" value="{{ $item['task'] ?? '' }}" placeholder="Tätigkeit" />
                        <x-text-input name="time_items[{{ $i }}][hours]" type="number" step="0.25" value="{{ $item['hours'] ?? 0 }}" placeholder="Std." />
                    </div>
                @endforeach
            </div>
        </section>

        <section class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
            <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500">Hinweis & Kontakt</h2>
            <div class="mt-4 grid gap-4">
                <textarea name="notice" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm">{{ old('notice', $defaults['notice']) }}</textarea>
                <div class="grid gap-3 sm:grid-cols-3">
                    <x-text-input name="contact_company" value="{{ old('contact_company', $defaults['contact_company']) }}" placeholder="Firma" />
                    <x-text-input name="contact_phone" value="{{ old('contact_phone', $defaults['contact_phone']) }}" placeholder="Telefon" />
                    <x-text-input name="contact_email" type="email" value="{{ old('contact_email', $defaults['contact_email']) }}" placeholder="E-Mail" />
                </div>
            </div>
        </section>

        <div class="flex justify-end gap-3">
            <a href="{{ route('reports.index') }}" wire:navigate class="rounded-md border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-700">Cancel</a>
            <x-primary-button>Save Report</x-primary-button>
        </div>
    </div>
</form>
