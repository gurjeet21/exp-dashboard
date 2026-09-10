@php
    $badge = fn ($status) => [
        'ok' => 'bg-emerald-50 text-emerald-700',
        'updated' => 'bg-sky-50 text-sky-700',
        'warn' => 'bg-amber-50 text-amber-700',
        'err' => 'bg-rose-50 text-rose-700',
    ][$status ?: 'ok'] ?? 'bg-gray-100 text-gray-700';
    $label = fn ($status) => ['ok' => 'OK', 'updated' => 'UPDATE', 'warn' => 'WARN', 'err' => 'ERROR'][$status ?: 'ok'] ?? 'OK';
    $lines = fn ($text) => collect(preg_split('/\r\n|\r|\n/', (string) $text))->filter();
@endphp

<article class="rounded-lg bg-[#F7F5EF] p-8 text-[#1C2430] shadow-sm sm:p-12">
    <p class="font-mono text-xs uppercase tracking-[0.16em] text-sky-800">Wartungsbericht {{ $report->period_to?->format('m/Y') }}</p>
    <h2 class="mt-2 font-mono text-3xl font-bold">{{ $report->project->client->company_name }}</h2>
    <div class="mt-6 grid gap-2 text-sm sm:grid-cols-2">
        <p><span class="font-mono text-xs uppercase text-gray-500">Domain</span><br><strong>{{ $report->project->website_url ?: '-' }}</strong></p>
        <p><span class="font-mono text-xs uppercase text-gray-500">Betreuer</span><br><strong>{{ $report->caretaker ?: '-' }}</strong></p>
        <p><span class="font-mono text-xs uppercase text-gray-500">Zeitraum</span><br><strong>{{ $report->period_from?->format('d.m.Y') }} - {{ $report->period_to?->format('d.m.Y') }}</strong></p>
        <p><span class="font-mono text-xs uppercase text-gray-500">Gesamtzeit</span><br><strong>{{ $report->total_hours }} Std.</strong></p>
    </div>

    @foreach ([
        ['01', 'Systemwartung & Updates', $report->system_items ?? [], ['component', 'note']],
        ['02', 'Sicherheit & Schutzmaßnahmen', $report->security_items ?? [], ['measure', 'note']],
        ['03', 'Backups', $report->backup_items ?? [], ['period', 'result']],
    ] as [$num, $title, $items, $keys])
        <section class="mt-10">
            <h3 class="font-mono text-sm font-bold uppercase"><span class="mr-2 rounded bg-sky-100 px-2 py-1 text-sky-800">{{ $num }}</span>{{ $title }}</h3>
            <div class="mt-4 overflow-hidden rounded-md border border-[#DBD5C6]">
                <table class="min-w-full divide-y divide-[#DBD5C6] text-sm">
                    <tbody class="divide-y divide-[#DBD5C6]">
                        @foreach ($items as $item)
                            <tr>
                                <td class="w-1/3 px-4 py-3 font-semibold">{{ $item[$keys[0]] ?? '-' }}</td>
                                <td class="w-32 px-4 py-3"><span class="rounded px-2 py-1 text-xs font-bold {{ $badge($item['status'] ?? 'ok') }}">{{ $label($item['status'] ?? 'ok') }}</span></td>
                                <td class="px-4 py-3 text-gray-600">{{ $item[$keys[1]] ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    @endforeach

    <section class="mt-10">
        <h3 class="font-mono text-sm font-bold uppercase"><span class="mr-2 rounded bg-sky-100 px-2 py-1 text-sky-800">04</span>Performance & Uptime</h3>
        <div class="mt-4 grid gap-4 sm:grid-cols-2">
            <div class="rounded-md border border-[#DBD5C6] p-4"><p class="font-mono text-xs uppercase text-gray-500">Uptime</p><p class="mt-1 font-semibold">{{ $report->uptime ?: '-' }}</p></div>
            <div class="rounded-md border border-[#DBD5C6] p-4"><p class="font-mono text-xs uppercase text-gray-500">Ladezeit</p><p class="mt-1 font-semibold">{{ $report->load_time ?: '-' }}</p></div>
        </div>
        <ul class="mt-4 list-disc pl-5 text-sm text-gray-700">@foreach ($lines($report->optimizations) as $line)<li>{{ $line }}</li>@endforeach</ul>
    </section>

    <section class="mt-10">
        <h3 class="font-mono text-sm font-bold uppercase"><span class="mr-2 rounded bg-sky-100 px-2 py-1 text-sky-800">05</span>Fehler & Protokolle</h3>
        <ul class="mt-4 list-disc pl-5 text-sm text-gray-700">@foreach ($lines($report->errors) as $line)<li>{{ $line }}</li>@endforeach</ul>
    </section>

    <section class="mt-10">
        <h3 class="font-mono text-sm font-bold uppercase"><span class="mr-2 rounded bg-sky-100 px-2 py-1 text-sky-800">06</span>Wartungszeit</h3>
        <div class="mt-4 overflow-hidden rounded-md border border-[#DBD5C6]">
            <table class="min-w-full divide-y divide-[#DBD5C6] text-sm">
                <tbody class="divide-y divide-[#DBD5C6]">
                    @foreach ($report->time_items ?? [] as $item)
                        <tr><td class="px-4 py-3 font-semibold">{{ $item['task'] ?? '-' }}</td><td class="w-32 px-4 py-3">{{ number_format((float) ($item['hours'] ?? 0), 2) }} Std.</td></tr>
                    @endforeach
                    <tr><td class="px-4 py-3 font-bold">Gesamtzeit</td><td class="w-32 px-4 py-3 font-bold">{{ $report->total_hours }} Std.</td></tr>
                </tbody>
            </table>
        </div>
    </section>

    @if ($report->notice)
        <div class="mt-8 border-l-4 border-sky-800 bg-[#EFEADB] p-4 text-sm leading-6">{{ $report->notice }}</div>
    @endif

    <footer class="mt-8 border-t border-[#DBD5C6] pt-4 text-sm text-gray-600">
        <strong class="text-gray-950">{{ $report->contact_company ?: 'eXP Designs' }}</strong><br>
        {{ $report->contact_phone }}<br>
        {{ $report->contact_email }}
    </footer>
</article>
