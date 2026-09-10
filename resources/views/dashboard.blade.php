<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-base font-medium text-slate-500">Admin Dashboard</p>
                <h1 class="mt-3 text-3xl font-bold tracking-normal text-slate-950 sm:text-4xl">Projekt- und Kundenübersicht</h1>
            </div>

            <a href="{{ route('projects.create') }}" wire:navigate class="inline-flex items-center justify-center gap-2 rounded-md bg-neutral-800 px-5 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-neutral-700">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m7-7H5" />
                </svg>
                Neues Projekt
            </a>
        </div>
    </x-slot>

    <div class="bg-slate-100 py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm shadow-slate-200/60">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-slate-500">Aktive Projekte</p>
                        <span class="rounded-md bg-emerald-50 px-2.5 py-1 text-xs font-bold text-emerald-700">+12%</span>
                    </div>
                    <p class="mt-7 text-4xl font-bold text-slate-950">24</p>
                </section>

                <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm shadow-slate-200/60">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-slate-500">Offene Aufgaben</p>
                        <span class="rounded-md bg-amber-50 px-2.5 py-1 text-xs font-bold text-amber-700">Heute 7</span>
                    </div>
                    <p class="mt-7 text-4xl font-bold text-slate-950">38</p>
                </section>

                <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm shadow-slate-200/60">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-slate-500">Wartungsberichte</p>
                        <span class="rounded-md bg-sky-50 px-2.5 py-1 text-xs font-bold text-sky-700">Sep 2026</span>
                    </div>
                    <p class="mt-7 text-4xl font-bold text-slate-950">8</p>
                </section>

                <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm shadow-slate-200/60">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-slate-500">Tickets</p>
                        <span class="rounded-md bg-rose-50 px-2.5 py-1 text-xs font-bold text-rose-700">2 Hoch</span>
                    </div>
                    <p class="mt-7 text-4xl font-bold text-slate-950">5</p>
                </section>
            </div>

            <div class="mt-6 grid gap-6 xl:grid-cols-[1.55fr_1fr]">
                <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm shadow-slate-200/60">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <h2 class="text-xl font-bold text-slate-950">Aufgaben Control Center</h2>
                        <div class="flex flex-wrap gap-2">
                            <span class="rounded-full border border-slate-200 px-3 py-1.5 text-sm text-slate-500">Monat: September</span>
                            <span class="rounded-full border border-slate-200 px-3 py-1.5 text-sm text-slate-500">Status: Offen</span>
                            <span class="rounded-full border border-slate-200 px-3 py-1.5 text-sm text-slate-500">Client sichtbar</span>
                        </div>
                    </div>

                    <div class="mt-7 overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead>
                                <tr>
                                    <th class="px-3 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Aufgabe</th>
                                    <th class="px-3 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Kunde</th>
                                    <th class="px-3 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Entwickler</th>
                                    <th class="px-3 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Priorität</th>
                                    <th class="px-3 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Status</th>
                                    <th class="px-3 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Std.</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ([
                                    ['task' => 'Rechtstexte einholen', 'note' => 'Blockiert Modul 4', 'client' => 'Jesaja Bruch UG', 'owner' => 'Kevin', 'priority' => 'Hoch', 'priorityClass' => 'bg-rose-50 text-rose-700', 'status' => 'Offen', 'hours' => '1.5'],
                                    ['task' => 'Plugin Updates prüfen', 'note' => 'Wartungsbericht September', 'client' => 'Spanferkel Catering', 'owner' => 'Gurjeet', 'priority' => 'Mittel', 'priorityClass' => 'bg-amber-50 text-amber-700', 'status' => 'In Arbeit', 'hours' => '0.75'],
                                    ['task' => 'Content Bilder hochladen', 'note' => 'Client sichtbar', 'client' => 'SEG Energie', 'owner' => 'Marvin', 'priority' => 'Normal', 'priorityClass' => 'bg-sky-50 text-sky-700', 'status' => 'Wartet auf Kunde', 'hours' => '0.25'],
                                ] as $row)
                                    <tr>
                                        <td class="px-3 py-5">
                                            <p class="font-bold text-slate-950">{{ $row['task'] }}</p>
                                            <p class="mt-1 text-sm text-slate-500">{{ $row['note'] }}</p>
                                        </td>
                                        <td class="px-3 py-5 text-sm text-slate-700">{{ $row['client'] }}</td>
                                        <td class="px-3 py-5 text-sm text-slate-700">{{ $row['owner'] }}</td>
                                        <td class="px-3 py-5"><span class="rounded-md px-2.5 py-1 text-xs font-bold {{ $row['priorityClass'] }}">{{ $row['priority'] }}</span></td>
                                        <td class="px-3 py-5 text-sm text-slate-700">{{ $row['status'] }}</td>
                                        <td class="px-3 py-5 text-sm text-slate-700">{{ $row['hours'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>

                <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm shadow-slate-200/60">
                    <h2 class="text-xl font-bold text-slate-950">Heute wichtig</h2>
                    <div class="mt-7 space-y-7">
                        @foreach ([
                            ['title' => '3 Berichte fällig', 'text' => 'Monatsberichte müssen geprüft werden'],
                            ['title' => '2 neue Uploads', 'text' => 'Client documents waiting for review'],
                            ['title' => '1 Ticket eskaliert', 'text' => 'Priority high, assigned to Kevin'],
                            ['title' => 'Stundenlog', 'text' => '12.25 hours tracked this week'],
                        ] as $item)
                            <div class="grid grid-cols-[14px_1fr] gap-4">
                                <span class="mt-1.5 h-3 w-3 rounded-full bg-neutral-700"></span>
                                <div>
                                    <p class="font-bold text-slate-950">{{ $item['title'] }}</p>
                                    <p class="mt-1 text-sm text-slate-500">{{ $item['text'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>

            <div class="mt-6 grid gap-6 lg:grid-cols-3">
                <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm shadow-slate-200/60 lg:col-span-2">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold text-slate-950">Wartungsberichte Fortschritt</h2>
                        <a href="{{ route('reports.index') }}" wire:navigate class="text-sm font-bold text-neutral-700">Alle anzeigen</a>
                    </div>

                    <div class="mt-7 grid gap-5">
                        @foreach ([
                            ['label' => 'Woche 1', 'completed' => 85],
                            ['label' => 'Woche 2', 'completed' => 62],
                            ['label' => 'Woche 3', 'completed' => 48],
                            ['label' => 'Woche 4', 'completed' => 28],
                        ] as $week)
                            <div>
                                <div class="mb-2 flex items-center justify-between text-sm">
                                    <span class="font-semibold text-slate-700">{{ $week['label'] }}</span>
                                    <span class="text-slate-500">{{ $week['completed'] }}% erledigt</span>
                                </div>
                                <div class="h-3 overflow-hidden rounded-full bg-slate-100">
                                    <div class="h-full rounded-full bg-neutral-800" style="width: {{ $week['completed'] }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>

                <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm shadow-slate-200/60">
                    <h2 class="text-xl font-bold text-slate-950">Project Health</h2>
                    <div class="mt-7 flex items-center justify-center">
                        <div class="relative h-36 w-36 rounded-full" style="background: conic-gradient(#2f2f2f 0 72%, #22c55e 72% 87%, #f59e0b 87% 96%, #ef4444 96% 100%);">
                            <div class="absolute inset-5 flex flex-col items-center justify-center rounded-full bg-white">
                                <span class="text-3xl font-bold text-slate-950">92%</span>
                                <span class="text-xs font-semibold text-slate-500">healthy</span>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
