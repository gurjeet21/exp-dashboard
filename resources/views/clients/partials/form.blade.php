@php
    $profile = $client->profile;
    $value = fn ($field, $default = '') => old($field, $profile?->{$field} ?? $default);
    $lines = fn ($field) => old($field.'_text', implode("\n", $profile?->{$field} ?? []));
@endphp

<form method="POST" action="{{ $action }}" class="space-y-6">
    @csrf
    @if ($method !== 'POST') @method($method) @endif

    <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm shadow-slate-200/60">
        <div class="border-b border-slate-100 pb-5">
            <h2 class="text-lg font-bold text-slate-950">Kunden-Stammdaten</h2>
            <p class="mt-1 text-sm text-slate-500">Nur die allgemeinen Kundendaten. Projekt, Technik, SEO und Wartung werden im Projekt gepflegt.</p>
        </div>

        <div class="mt-6 grid gap-5 sm:grid-cols-2">
            <div>
                <x-input-label for="company_name" value="Kundenname / Firma" />
                <x-text-input id="company_name" name="company_name" class="mt-1 block w-full" value="{{ old('company_name', $client->company_name) }}" required />
                <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="short_code" value="Kurzname / Kürzel" />
                <x-text-input id="short_code" name="short_code" class="mt-1 block w-full" value="{{ $value('short_code') }}" placeholder="[SC]" />
            </div>

            <div>
                <x-input-label for="industry" value="Branche" />
                <x-text-input id="industry" name="industry" class="mt-1 block w-full" value="{{ $value('industry') }}" placeholder="Gastronomie, Energie, Kanzlei..." />
            </div>

            <div>
                <x-input-label for="legal_form" value="Rechtsform" />
                <x-text-input id="legal_form" name="legal_form" class="mt-1 block w-full" value="{{ $value('legal_form') }}" placeholder="GmbH, UG, Einzelunternehmen..." />
            </div>

            <div>
                <x-input-label for="contact_name" value="Hauptkontakt" />
                <x-text-input id="contact_name" name="contact_name" class="mt-1 block w-full" value="{{ old('contact_name', $client->contact_name) }}" />
            </div>

            <div>
                <x-input-label for="email" value="Primäre E-Mail" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" value="{{ old('email', $client->email) }}" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="phone" value="Telefon" />
                <x-text-input id="phone" name="phone" class="mt-1 block w-full" value="{{ old('phone', $client->phone) }}" />
            </div>

            <div>
                <x-input-label for="preferred_channel" value="Bevorzugter Kontaktweg" />
                <x-text-input id="preferred_channel" name="preferred_channel" class="mt-1 block w-full" value="{{ $value('preferred_channel') }}" placeholder="E-Mail, Telefon, WhatsApp" />
            </div>

            <div>
                <x-input-label for="customer_since" value="Kunde seit" />
                <x-text-input id="customer_since" name="customer_since" class="mt-1 block w-full" value="{{ $value('customer_since') }}" placeholder="2024" />
            </div>

            <div>
                <x-input-label for="status" value="Status" />
                <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="active" @selected(old('status', $client->status ?: 'active') === 'active')>Aktiv</option>
                    <option value="inactive" @selected(old('status', $client->status) === 'inactive')>Pausiert / Inaktiv</option>
                </select>
            </div>
        </div>

        <div class="mt-5 grid gap-5 sm:grid-cols-2">
            <div>
                <x-input-label for="emails_text" value="Weitere E-Mails (eine pro Zeile)" />
                <textarea id="emails_text" name="emails_text" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ $lines('emails') }}</textarea>
            </div>

            <div>
                <x-input-label for="phones_text" value="Weitere Telefonnummern (eine pro Zeile)" />
                <textarea id="phones_text" name="phones_text" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ $lines('phones') }}</textarea>
            </div>
        </div>

        <div class="mt-5">
            <x-input-label for="address" value="Adresse" />
            <textarea id="address" name="address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('address', $client->address) }}</textarea>
        </div>

        <div class="mt-5">
            <x-input-label for="personal_notes" value="Interne Notizen zum Kunden" />
            <textarea id="personal_notes" name="personal_notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ $value('personal_notes') }}</textarea>
        </div>
    </section>

    <div class="flex justify-end gap-3">
        <a href="{{ route('clients.index') }}" wire:navigate class="rounded-md border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700">{{ __('app.cancel') }}</a>
        <x-primary-button>{{ __('app.clients.save') }}</x-primary-button>
    </div>
</form>
