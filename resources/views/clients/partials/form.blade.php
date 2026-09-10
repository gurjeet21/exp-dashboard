@php
    $profile = $client->profile;
    $value = fn ($field, $default = '') => old($field, $profile?->{$field} ?? $default);
    $checked = fn ($field, $option) => in_array($option, old($field, $profile?->{$field} ?? []), true);
    $lines = fn ($field) => old($field.'_text', implode("\n", $profile?->{$field} ?? []));
    $projectTypes = ['Webdesign / Relaunch', 'Online Shop', 'Landing Page', 'Web-App', 'Wartung', 'SEO', 'Marketing', 'Entwicklung', 'Stundenvertrag'];
    $services = ['Webdesign / Relaunch', 'WordPress Entwicklung', 'Online Shop', 'Landing Pages', 'Wartung & Support', 'SEO & Sichtbarkeit', 'Content & Texte', 'Social Media', 'Google Ads / Werbung', 'E-Mail Marketing', 'Grafikdesign / CI', 'KI-Integration / Automatisierung'];
    $seoChecks = ['Google Search Console vorhanden', 'Google Analytics 4 vorhanden', 'Google My Business Profil vorhanden', 'Bing Webmaster Tools vorhanden', 'Core Web Vitals geprüft', 'Sitemap eingereicht'];
@endphp

<form method="POST" action="{{ $action }}" class="space-y-6">
    @csrf
    @if ($method !== 'POST') @method($method) @endif

    <section class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
        <h2 class="text-base font-semibold text-gray-950">1. Stammdaten</h2>
        <div class="mt-5 grid gap-5 sm:grid-cols-2">
            <div>
                <x-input-label for="company_name" value="Kundenname" />
                <x-text-input id="company_name" name="company_name" class="mt-1 block w-full" value="{{ old('company_name', $client->company_name) }}" required />
                <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
            </div>
            <div><x-input-label for="short_code" value="Kurzname / Kürzel" /><x-text-input id="short_code" name="short_code" class="mt-1 block w-full" value="{{ $value('short_code') }}" placeholder="[SC]" /></div>
            <div><x-input-label for="industry" value="Branche" /><x-text-input id="industry" name="industry" class="mt-1 block w-full" value="{{ $value('industry') }}" /></div>
            <div><x-input-label for="legal_form" value="Rechtsform" /><x-text-input id="legal_form" name="legal_form" class="mt-1 block w-full" value="{{ $value('legal_form') }}" /></div>
            <div><x-input-label for="customer_since" value="Kunde seit" /><x-text-input id="customer_since" name="customer_since" class="mt-1 block w-full" value="{{ $value('customer_since') }}" placeholder="2024" /></div>
            <div>
                <x-input-label for="customer_value" value="Kundenwert" />
                <select id="customer_value" name="customer_value" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">Bitte auswählen</option>
                    @foreach (['Standard', 'Premium', 'Enterprise', 'Partner'] as $option)
                        <option value="{{ $option }}" @selected($value('customer_value') === $option)>{{ $option }}</option>
                    @endforeach
                </select>
            </div>
            <div><x-input-label for="status" value="Status" /><select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"><option value="active" @selected(old('status', $client->status ?: 'active') === 'active')>Aktiv</option><option value="inactive" @selected(old('status', $client->status) === 'inactive')>Pausiert / Inaktiv</option></select></div>
            <div><x-input-label for="email" value="Primäre E-Mail" /><x-text-input id="email" name="email" type="email" class="mt-1 block w-full" value="{{ old('email', $client->email) }}" /></div>
            <div><x-input-label for="phone" value="Primäres Telefon" /><x-text-input id="phone" name="phone" class="mt-1 block w-full" value="{{ old('phone', $client->phone) }}" /></div>
            <div><x-input-label for="contact_name" value="Hauptkontakt" /><x-text-input id="contact_name" name="contact_name" class="mt-1 block w-full" value="{{ old('contact_name', $client->contact_name) }}" /></div>
        </div>
        <div class="mt-5"><x-input-label for="address" value="Adresse" /><textarea id="address" name="address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('address', $client->address) }}</textarea></div>
    </section>

    <section class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
        <h2 class="text-base font-semibold text-gray-950">2. Kommunikation</h2>
        <div class="mt-5 grid gap-5 sm:grid-cols-2">
            <div><x-input-label for="emails_text" value="Weitere E-Mails (eine pro Zeile)" /><textarea id="emails_text" name="emails_text" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ $lines('emails') }}</textarea></div>
            <div><x-input-label for="phones_text" value="Weitere Telefonnummern (eine pro Zeile)" /><textarea id="phones_text" name="phones_text" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ $lines('phones') }}</textarea></div>
            <div><x-input-label for="preferred_channel" value="Bevorzugter Kanal" /><x-text-input id="preferred_channel" name="preferred_channel" class="mt-1 block w-full" value="{{ $value('preferred_channel') }}" placeholder="E-Mail, Telefon, WhatsApp" /></div>
            <div><x-input-label for="decision_maker" value="Entscheidungsträger" /><x-text-input id="decision_maker" name="decision_maker" class="mt-1 block w-full" value="{{ $value('decision_maker') }}" /></div>
            <div><x-input-label for="secondary_contact" value="Weiterer Kontakt" /><x-text-input id="secondary_contact" name="secondary_contact" class="mt-1 block w-full" value="{{ $value('secondary_contact') }}" /></div>
            <div><x-input-label for="availability" value="Erreichbarkeit" /><x-text-input id="availability" name="availability" class="mt-1 block w-full" value="{{ $value('availability') }}" /></div>
        </div>
    </section>

    <section class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
        <h2 class="text-base font-semibold text-gray-950">3. Technisches Setup</h2>
        <div class="mt-5">
            <x-input-label value="Projektart" />
            <div class="mt-2 grid gap-2 sm:grid-cols-3">
                @foreach ($projectTypes as $option)
                    <label class="flex items-center gap-2 text-sm text-gray-700"><input type="checkbox" name="project_types[]" value="{{ $option }}" @checked($checked('project_types', $option)) class="rounded border-gray-300"> {{ $option }}</label>
                @endforeach
            </div>
        </div>
        <div class="mt-5 grid gap-5 sm:grid-cols-2">
            <div><x-input-label for="cms" value="CMS" /><x-text-input id="cms" name="cms" class="mt-1 block w-full" value="{{ $value('cms') }}" placeholder="WordPress" /></div>
            <div><x-input-label for="theme_builder" value="Theme / Builder" /><x-text-input id="theme_builder" name="theme_builder" class="mt-1 block w-full" value="{{ $value('theme_builder') }}" placeholder="Elementor" /></div>
            <div><x-input-label for="hosting" value="Hosting" /><x-text-input id="hosting" name="hosting" class="mt-1 block w-full" value="{{ $value('hosting') }}" /></div>
            <div><x-input-label for="domain_registrar" value="Domain-Registrar" /><x-text-input id="domain_registrar" name="domain_registrar" class="mt-1 block w-full" value="{{ $value('domain_registrar') }}" /></div>
            <div><x-input-label for="ssl_certificate" value="SSL-Zertifikat" /><x-text-input id="ssl_certificate" name="ssl_certificate" class="mt-1 block w-full" value="{{ $value('ssl_certificate') }}" /></div>
        </div>
    </section>

    <section class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
        <h2 class="text-base font-semibold text-gray-950">4. Tools, Leistungen & Marke</h2>
        <div class="mt-5 grid gap-5">
            <div><x-input-label for="customer_tools_text" value="Aktive Tools & Dienste (eine pro Zeile)" /><textarea id="customer_tools_text" name="customer_tools_text" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ $lines('customer_tools') }}</textarea></div>
            <div>
                <x-input-label value="Unsere Leistungen - Aktiv" />
                <div class="mt-2 grid gap-2 sm:grid-cols-3">@foreach ($services as $option)<label class="flex items-center gap-2 text-sm text-gray-700"><input type="checkbox" name="services_active[]" value="{{ $option }}" @checked($checked('services_active', $option)) class="rounded border-gray-300"> {{ $option }}</label>@endforeach</div>
            </div>
            <div>
                <x-input-label value="Unsere Leistungen - Potenzial" />
                <div class="mt-2 grid gap-2 sm:grid-cols-3">@foreach ($services as $option)<label class="flex items-center gap-2 text-sm text-gray-700"><input type="checkbox" name="services_potential[]" value="{{ $option }}" @checked($checked('services_potential', $option)) class="rounded border-gray-300"> {{ $option }}</label>@endforeach</div>
            </div>
            <div class="grid gap-5 sm:grid-cols-2">
                <div><x-input-label for="tonality" value="Tonalität" /><x-text-input id="tonality" name="tonality" class="mt-1 block w-full" value="{{ $value('tonality') }}" /></div>
                <div><x-input-label for="primary_colors" value="Primärfarbe(n)" /><x-text-input id="primary_colors" name="primary_colors" class="mt-1 block w-full" value="{{ $value('primary_colors') }}" placeholder="#HEX + #HEX" /></div>
                <div><x-input-label for="fonts" value="Schriftarten" /><x-text-input id="fonts" name="fonts" class="mt-1 block w-full" value="{{ $value('fonts') }}" /></div>
                <div><x-input-label for="logo_link" value="Logo / Drive-Link" /><x-text-input id="logo_link" name="logo_link" class="mt-1 block w-full" value="{{ $value('logo_link') }}" /></div>
            </div>
            <div><x-input-label for="target_group" value="Zielgruppe" /><textarea id="target_group" name="target_group" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ $value('target_group') }}</textarea></div>
            <div><x-input-label for="brand_notes" value="Dos & Don'ts" /><textarea id="brand_notes" name="brand_notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ $value('brand_notes') }}</textarea></div>
        </div>
    </section>

    <section class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
        <h2 class="text-base font-semibold text-gray-950">5. SEO & Interne Notizen</h2>
        <div class="mt-5">
            <x-input-label value="SEO Quick-Check" />
            <div class="mt-2 grid gap-2 sm:grid-cols-2">
                @foreach ($seoChecks as $option)
                    <label class="flex items-center gap-2 text-sm text-gray-700"><input type="checkbox" name="seo_checks[]" value="{{ $option }}" @checked($checked('seo_checks', $option)) class="rounded border-gray-300"> {{ $option }}</label>
                @endforeach
            </div>
        </div>
        <div class="mt-5 grid gap-5 sm:grid-cols-2">
            <div><x-input-label for="main_keywords" value="Hauptkeywords" /><textarea id="main_keywords" name="main_keywords" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ $value('main_keywords') }}</textarea></div>
            <div><x-input-label for="current_rankings" value="Aktuelle Rankings" /><textarea id="current_rankings" name="current_rankings" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ $value('current_rankings') }}</textarea></div>
            <div><x-input-label for="last_seo_review" value="Letzte SEO-Prüfung" /><x-text-input id="last_seo_review" name="last_seo_review" class="mt-1 block w-full" value="{{ $value('last_seo_review') }}" /></div>
            <div><x-input-label for="internal_owner" value="Zuständig intern" /><x-text-input id="internal_owner" name="internal_owner" class="mt-1 block w-full" value="{{ $value('internal_owner') }}" /></div>
            <div><x-input-label for="satisfaction" value="Kundenzufriedenheit" /><x-text-input id="satisfaction" name="satisfaction" class="mt-1 block w-full" value="{{ $value('satisfaction') }}" /></div>
            <div><x-input-label for="payment_behavior" value="Zahlungsverhalten" /><x-text-input id="payment_behavior" name="payment_behavior" class="mt-1 block w-full" value="{{ $value('payment_behavior') }}" /></div>
        </div>
        <div class="mt-5 grid gap-5">
            <div><x-input-label for="seo_notes" value="SEO-Notizen" /><textarea id="seo_notes" name="seo_notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ $value('seo_notes') }}</textarea></div>
            <div><x-input-label for="personal_notes" value="Persönliches" /><textarea id="personal_notes" name="personal_notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ $value('personal_notes') }}</textarea></div>
            <div><x-input-label for="internal_warnings" value="Interne Warnhinweise" /><textarea id="internal_warnings" name="internal_warnings" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ $value('internal_warnings') }}</textarea></div>
            <div class="grid gap-5 sm:grid-cols-2">
                <div><x-input-label for="last_updated_on" value="Zuletzt aktualisiert am" /><x-text-input id="last_updated_on" name="last_updated_on" type="date" class="mt-1 block w-full" value="{{ old('last_updated_on', $profile?->last_updated_on?->format('Y-m-d')) }}" /></div>
                <div><x-input-label for="last_updated_by" value="Von" /><x-text-input id="last_updated_by" name="last_updated_by" class="mt-1 block w-full" value="{{ $value('last_updated_by') }}" /></div>
            </div>
        </div>
    </section>

    <div class="flex justify-end gap-3">
        <a href="{{ route('clients.index') }}" wire:navigate class="rounded-md border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-700">Cancel</a>
        <x-primary-button>Save Kundenprofil</x-primary-button>
    </div>
</form>
