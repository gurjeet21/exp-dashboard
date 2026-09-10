<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Agency Command Center</p>
                <h1 class="mt-1 text-2xl font-semibold tracking-normal text-gray-950">Dashboard</h1>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('projects.create') }}" wire:navigate class="inline-flex items-center gap-2 rounded-md border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm transition hover:border-gray-300 hover:bg-gray-50">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m7-7H5" />
                    </svg>
                    New Project
                </a>

                <a href="{{ route('reports.create') }}" wire:navigate class="inline-flex items-center gap-2 rounded-md bg-gray-950 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-800">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 3h10a2 2 0 0 1 2 2v14l-4-2-3 2-3-2-4 2V5a2 2 0 0 1 2-2Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 8h6M9 12h6" />
                    </svg>
                    New Report
                </a>
            </div>
        </div>
    </x-slot>

    <div class="bg-gray-100 py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-gray-500">Active Projects</p>
                        <span class="rounded-md bg-emerald-50 px-2 py-1 text-xs font-semibold text-emerald-700">+12%</span>
                    </div>
                    <div class="mt-4 flex items-end justify-between">
                        <p class="text-3xl font-semibold text-gray-950">24</p>
                        <svg class="h-10 w-24 text-emerald-500" viewBox="0 0 120 44" fill="none" aria-hidden="true">
                            <path d="M2 34C16 28 20 10 36 16C51 22 52 34 68 24C83 15 91 8 118 10" stroke="currentColor" stroke-width="3" stroke-linecap="round" />
                        </svg>
                    </div>
                    <p class="mt-3 text-sm text-gray-500">Websites and retainers currently in progress.</p>
                </div>

                <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-gray-500">Pending Reports</p>
                        <span class="rounded-md bg-amber-50 px-2 py-1 text-xs font-semibold text-amber-700">This month</span>
                    </div>
                    <div class="mt-4 flex items-end justify-between">
                        <p class="text-3xl font-semibold text-gray-950">8</p>
                        <div class="flex h-10 items-end gap-1.5">
                            <span class="h-5 w-2 rounded bg-amber-200"></span>
                            <span class="h-8 w-2 rounded bg-amber-300"></span>
                            <span class="h-4 w-2 rounded bg-amber-200"></span>
                            <span class="h-10 w-2 rounded bg-amber-500"></span>
                            <span class="h-6 w-2 rounded bg-amber-300"></span>
                        </div>
                    </div>
                    <p class="mt-3 text-sm text-gray-500">Maintenance reports still waiting for review.</p>
                </div>

                <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-gray-500">Open Tickets</p>
                        <span class="rounded-md bg-rose-50 px-2 py-1 text-xs font-semibold text-rose-700">Later module</span>
                    </div>
                    <div class="mt-4 flex items-end justify-between">
                        <p class="text-3xl font-semibold text-gray-950">5</p>
                        <svg class="h-10 w-24 text-rose-500" viewBox="0 0 120 44" fill="none" aria-hidden="true">
                            <path d="M2 10C20 14 22 33 38 30C54 27 55 12 70 14C87 16 91 35 118 24" stroke="currentColor" stroke-width="3" stroke-linecap="round" />
                        </svg>
                    </div>
                    <p class="mt-3 text-sm text-gray-500">Client issues will appear here after ticketing.</p>
                </div>

                <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-gray-500">Monthly Revenue</p>
                        <span class="rounded-md bg-sky-50 px-2 py-1 text-xs font-semibold text-sky-700">Planned</span>
                    </div>
                    <div class="mt-4 flex items-end justify-between">
                        <p class="text-3xl font-semibold text-gray-950">€4.8k</p>
                        <div class="flex h-10 items-end gap-1.5">
                            <span class="h-4 w-2 rounded bg-sky-200"></span>
                            <span class="h-6 w-2 rounded bg-sky-300"></span>
                            <span class="h-8 w-2 rounded bg-sky-400"></span>
                            <span class="h-7 w-2 rounded bg-sky-300"></span>
                            <span class="h-10 w-2 rounded bg-sky-600"></span>
                        </div>
                    </div>
                    <p class="mt-3 text-sm text-gray-500">Invoices and retainers will feed this card later.</p>
                </div>
            </div>

            <div class="mt-6 grid gap-6 lg:grid-cols-3">
                <section class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm lg:col-span-2">
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <h2 class="text-base font-semibold text-gray-950">Maintenance Report Progress</h2>
                            <p class="mt-1 text-sm text-gray-500">Current month report pipeline across active projects.</p>
                        </div>
                        <div class="flex items-center gap-3 text-xs font-medium text-gray-500">
                            <span class="flex items-center gap-1.5"><span class="h-2.5 w-2.5 rounded-full bg-gray-950"></span>Completed</span>
                            <span class="flex items-center gap-1.5"><span class="h-2.5 w-2.5 rounded-full bg-amber-400"></span>Pending</span>
                        </div>
                    </div>

                    <div class="mt-8 grid gap-5">
                        @foreach ([
                            ['label' => 'Week 1', 'completed' => 85, 'pending' => 15],
                            ['label' => 'Week 2', 'completed' => 62, 'pending' => 38],
                            ['label' => 'Week 3', 'completed' => 48, 'pending' => 52],
                            ['label' => 'Week 4', 'completed' => 28, 'pending' => 72],
                        ] as $week)
                            <div>
                                <div class="mb-2 flex items-center justify-between text-sm">
                                    <span class="font-medium text-gray-700">{{ $week['label'] }}</span>
                                    <span class="text-gray-500">{{ $week['completed'] }}% completed</span>
                                </div>
                                <div class="flex h-3 overflow-hidden rounded-full bg-gray-100">
                                    <div class="bg-gray-950" style="width: {{ $week['completed'] }}%"></div>
                                    <div class="bg-amber-400" style="width: {{ $week['pending'] }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>

                <section class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                    <h2 class="text-base font-semibold text-gray-950">Project Health</h2>
                    <p class="mt-1 text-sm text-gray-500">A quick operational view.</p>

                    <div class="mt-6 flex items-center justify-center">
                        <div class="relative h-40 w-40 rounded-full" style="background: conic-gradient(#111827 0 68%, #10b981 68% 84%, #f59e0b 84% 94%, #ef4444 94% 100%);">
                            <div class="absolute inset-5 flex flex-col items-center justify-center rounded-full bg-white">
                                <span class="text-3xl font-semibold text-gray-950">92%</span>
                                <span class="text-xs font-medium text-gray-500">healthy</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 space-y-3 text-sm">
                        <div class="flex items-center justify-between">
                            <span class="flex items-center gap-2 text-gray-600"><span class="h-2.5 w-2.5 rounded-full bg-gray-950"></span>Stable</span>
                            <span class="font-semibold text-gray-900">18</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="flex items-center gap-2 text-gray-600"><span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>Recently updated</span>
                            <span class="font-semibold text-gray-900">4</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="flex items-center gap-2 text-gray-600"><span class="h-2.5 w-2.5 rounded-full bg-amber-500"></span>Needs review</span>
                            <span class="font-semibold text-gray-900">2</span>
                        </div>
                    </div>
                </section>
            </div>

            <div class="mt-6 grid gap-6 lg:grid-cols-3">
                <section class="rounded-lg border border-gray-200 bg-white shadow-sm lg:col-span-2">
                    <div class="border-b border-gray-100 px-6 py-4">
                        <h2 class="text-base font-semibold text-gray-950">Upcoming Maintenance</h2>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">Project</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">Owner</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">Due</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @foreach ([
                                    ['project' => 'Kanzlei Website Care', 'owner' => 'Gurjeet', 'due' => '10 Jul', 'status' => 'Report draft', 'color' => 'amber'],
                                    ['project' => 'Shop Maintenance', 'owner' => 'Amandeep', 'due' => '12 Jul', 'status' => 'Backup check', 'color' => 'sky'],
                                    ['project' => 'Portfolio Refresh', 'owner' => 'Gurjeet', 'due' => '15 Jul', 'status' => 'Ready to send', 'color' => 'emerald'],
                                ] as $item)
                                    <tr>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm font-semibold text-gray-950">{{ $item['project'] }}</td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">{{ $item['owner'] }}</td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">{{ $item['due'] }}</td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <span @class([
                                                'inline-flex rounded-md px-2 py-1 text-xs font-semibold',
                                                'bg-amber-50 text-amber-700' => $item['color'] === 'amber',
                                                'bg-sky-50 text-sky-700' => $item['color'] === 'sky',
                                                'bg-emerald-50 text-emerald-700' => $item['color'] === 'emerald',
                                            ])>{{ $item['status'] }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>

                <section class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                    <h2 class="text-base font-semibold text-gray-950">Recent Activity</h2>
                    <div class="mt-5 space-y-5">
                        @foreach ([
                            ['title' => 'Monthly report generated', 'meta' => 'Kanzlei Website Care · 18 min ago'],
                            ['title' => 'Backup completed', 'meta' => 'Shop Maintenance · 1 hr ago'],
                            ['title' => 'Client ticket planned', 'meta' => 'Future module · Today'],
                            ['title' => 'Invoice tracking planned', 'meta' => 'Future module · This sprint'],
                        ] as $activity)
                            <div class="flex gap-3">
                                <div class="mt-1 h-2.5 w-2.5 rounded-full bg-gray-950"></div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">{{ $activity['title'] }}</p>
                                    <p class="mt-1 text-sm text-gray-500">{{ $activity['meta'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
