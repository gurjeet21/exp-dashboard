<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">{{ __('app.clients.eyebrow') }}</p>
                <h1 class="mt-1 text-2xl font-semibold text-gray-950">{{ __('app.clients.title') }}</h1>
            </div>
            <a href="{{ route('clients.create') }}" wire:navigate class="rounded-md bg-gray-950 px-4 py-2 text-sm font-semibold text-white">{{ __('app.clients.new') }}</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <form method="GET" action="{{ route('clients.index') }}" class="mb-6 rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                <div class="grid gap-4 lg:grid-cols-6">
                    <div class="lg:col-span-2">
                        <label for="search" class="text-xs font-semibold uppercase text-gray-500">{{ __('app.filters.search') }}</label>
                        <input id="search" name="search" value="{{ $filters['search'] ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm" placeholder="{{ __('app.clients.columns.company') }}, {{ __('app.clients.columns.contact') }}, E-Mail, Code">
                    </div>
                    <div>
                        <label for="status" class="text-xs font-semibold uppercase text-gray-500">{{ __('app.filters.status') }}</label>
                        <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm">
                            <option value="">{{ __('app.all') }}</option>
                            <option value="active" @selected(($filters['status'] ?? '') === 'active')>{{ __('app.status.active') }}</option>
                            <option value="inactive" @selected(($filters['status'] ?? '') === 'inactive')>{{ __('app.status.inactive') }}</option>
                        </select>
                    </div>
                    <div>
                        <label for="customer_value" class="text-xs font-semibold uppercase text-gray-500">{{ __('app.filters.value') }}</label>
                        <select id="customer_value" name="customer_value" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm">
                            <option value="">{{ __('app.all') }}</option>
                            @foreach (['Standard', 'Premium', 'Enterprise', 'Partner'] as $value)
                                <option value="{{ $value }}" @selected(($filters['customer_value'] ?? '') === $value)>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="industry" class="text-xs font-semibold uppercase text-gray-500">{{ __('app.filters.industry') }}</label>
                        <input id="industry" name="industry" value="{{ $filters['industry'] ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm" placeholder="Catering">
                    </div>
                    <div>
                        <label for="per_page" class="text-xs font-semibold uppercase text-gray-500">{{ __('app.filters.per_page') }}</label>
                        <select id="per_page" name="per_page" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm">
                            @foreach ([12, 25, 50, 100] as $size)
                                <option value="{{ $size }}" @selected((int) request('per_page', 12) === $size)>{{ $size }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-4 flex gap-2">
                    <button class="rounded-md bg-gray-950 px-4 py-2 text-sm font-semibold text-white">{{ __('app.apply') }}</button>
                    <a href="{{ route('clients.index') }}" wire:navigate class="rounded-md border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-700">{{ __('app.reset') }}</a>
                </div>
            </form>

            <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">{{ __('app.clients.columns.company') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">{{ __('app.clients.columns.contact') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">{{ __('app.clients.columns.projects') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">{{ __('app.clients.columns.status') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($clients as $client)
                            <tr>
                                <td class="px-6 py-4">
                                    <a href="{{ route('clients.show', $client) }}" wire:navigate class="font-semibold text-gray-950 hover:text-gray-700">{{ $client->company_name }}</a>
                                    <p class="text-sm text-gray-500">{{ $client->email ?: __('app.no_email') }}</p>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $client->contact_name ?: '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $client->projects_count }}</td>
                                <td class="px-6 py-4"><span class="rounded-md bg-emerald-50 px-2 py-1 text-xs font-semibold text-emerald-700">{{ __('app.status.'.$client->status) }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-6 py-10 text-center text-sm text-gray-500">{{ __('app.clients.no_clients') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $clients->links() }}</div>
        </div>
    </div>
</x-app-layout>
