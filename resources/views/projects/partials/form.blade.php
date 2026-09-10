<form method="POST" action="{{ $action }}" class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
    @csrf
    @if ($method !== 'POST') @method($method) @endif
    <div class="grid gap-5">
        <div>
            <x-input-label for="client_id" value="Client" />
            <select id="client_id" name="client_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                <option value="">Select client</option>
                @foreach ($clients as $client)
                    <option value="{{ $client->id }}" @selected((int) old('client_id', $project->client_id) === $client->id)>{{ $client->company_name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <x-input-label for="name" value="Project name" />
            <x-text-input id="name" name="name" class="mt-1 block w-full" value="{{ old('name', $project->name) }}" required />
        </div>
        <div class="grid gap-5 sm:grid-cols-2">
            <div><x-input-label for="website_url" value="Website URL" /><x-text-input id="website_url" name="website_url" class="mt-1 block w-full" value="{{ old('website_url', $project->website_url) }}" placeholder="https://example.de" /></div>
            <div><x-input-label for="assigned_user_id" value="Assigned user" /><select id="assigned_user_id" name="assigned_user_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"><option value="">Unassigned</option>@foreach ($users as $user)<option value="{{ $user->id }}" @selected((int) old('assigned_user_id', $project->assigned_user_id) === $user->id)>{{ $user->name }}</option>@endforeach</select></div>
            <div><x-input-label for="type" value="Type" /><x-text-input id="type" name="type" class="mt-1 block w-full" value="{{ old('type', $project->type ?: 'maintenance') }}" /></div>
            <div><x-input-label for="status" value="Status" /><select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"><option value="active" @selected(old('status', $project->status ?: 'active') === 'active')>Active</option><option value="paused" @selected(old('status', $project->status) === 'paused')>Paused</option><option value="completed" @selected(old('status', $project->status) === 'completed')>Completed</option></select></div>
            <div><x-input-label for="start_date" value="Start date" /><x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full" value="{{ old('start_date', $project->start_date?->format('Y-m-d')) }}" /></div>
            <div><x-input-label for="monthly_price" value="Monthly price" /><x-text-input id="monthly_price" name="monthly_price" type="number" step="0.01" class="mt-1 block w-full" value="{{ old('monthly_price', $project->monthly_price) }}" /></div>
        </div>
        <div><x-input-label for="notes" value="Notes" /><textarea id="notes" name="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('notes', $project->notes) }}</textarea></div>
    </div>
    <div class="mt-6 flex justify-end"><x-primary-button>Save Project</x-primary-button></div>
</form>
