<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Project Management</p>
                <h1 class="mt-1 text-2xl font-semibold text-gray-950">Projects</h1>
            </div>
            <a href="{{ route('projects.create') }}" wire:navigate class="rounded-md bg-gray-950 px-4 py-2 text-sm font-semibold text-white">New Project</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <form method="GET" action="{{ route('projects.index') }}" class="mb-6 rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                <div class="grid gap-4 lg:grid-cols-6">
                    <div class="lg:col-span-2">
                        <label for="search" class="text-xs font-semibold uppercase text-gray-500">Search</label>
                        <input id="search" name="search" value="{{ $filters['search'] ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm" placeholder="Project, client, URL">
                    </div>
                    <div>
                        <label for="client_id" class="text-xs font-semibold uppercase text-gray-500">Client</label>
                        <select id="client_id" name="client_id" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm">
                            <option value="">All clients</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}" @selected((string) ($filters['client_id'] ?? '') === (string) $client->id)>{{ $client->company_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="assigned_user_id" class="text-xs font-semibold uppercase text-gray-500">Assigned</label>
                        <select id="assigned_user_id" name="assigned_user_id" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm">
                            <option value="">All users</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" @selected((string) ($filters['assigned_user_id'] ?? '') === (string) $user->id)>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="status" class="text-xs font-semibold uppercase text-gray-500">Status</label>
                        <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm">
                            <option value="">All</option>
                            <option value="active" @selected(($filters['status'] ?? '') === 'active')>Active</option>
                            <option value="paused" @selected(($filters['status'] ?? '') === 'paused')>Paused</option>
                            <option value="completed" @selected(($filters['status'] ?? '') === 'completed')>Completed</option>
                        </select>
                    </div>
                    <div>
                        <label for="type" class="text-xs font-semibold uppercase text-gray-500">Type</label>
                        <input id="type" name="type" value="{{ $filters['type'] ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm" placeholder="maintenance">
                    </div>
                </div>
                <div class="mt-4 grid gap-4 sm:grid-cols-4">
                    <div>
                        <label for="start_from" class="text-xs font-semibold uppercase text-gray-500">Start from</label>
                        <input id="start_from" name="start_from" type="date" value="{{ $filters['start_from'] ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm">
                    </div>
                    <div>
                        <label for="start_to" class="text-xs font-semibold uppercase text-gray-500">Start to</label>
                        <input id="start_to" name="start_to" type="date" value="{{ $filters['start_to'] ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm">
                    </div>
                    <div>
                        <label for="per_page" class="text-xs font-semibold uppercase text-gray-500">Per page</label>
                        <select id="per_page" name="per_page" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm">
                            @foreach ([12, 25, 50, 100] as $size)
                                <option value="{{ $size }}" @selected((int) request('per_page', 12) === $size)>{{ $size }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end gap-2">
                        <button class="rounded-md bg-gray-950 px-4 py-2 text-sm font-semibold text-white">Apply</button>
                        <a href="{{ route('projects.index') }}" wire:navigate class="rounded-md border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-700">Reset</a>
                    </div>
                </div>
            </form>

            <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">Project</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">Client</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">Assigned</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($projects as $project)
                            <tr>
                                <td class="px-6 py-4">
                                    <a href="{{ route('projects.show', $project) }}" wire:navigate class="font-semibold text-gray-950 hover:text-gray-700">{{ $project->name }}</a>
                                    <p class="text-sm text-gray-500">{{ $project->website_url ?: 'No URL' }}</p>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $project->client->company_name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $project->assignedUser?->name ?: '-' }}</td>
                                <td class="px-6 py-4"><span class="rounded-md bg-emerald-50 px-2 py-1 text-xs font-semibold text-emerald-700">{{ ucfirst($project->status) }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-6 py-10 text-center text-sm text-gray-500">No projects yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $projects->links() }}</div>
        </div>
    </div>
</x-app-layout>
