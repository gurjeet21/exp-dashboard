<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'status', 'customer_value', 'industry']);

        $clients = Client::query()
            ->with('profile')
            ->withCount('projects')
            ->when($filters['search'] ?? null, function ($query, string $search): void {
                $query
                    ->where('company_name', 'like', "%{$search}%")
                    ->orWhere('contact_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('profile', fn ($profileQuery) => $profileQuery->where('short_code', 'like', "%{$search}%"));
            })
            ->when($filters['status'] ?? null, fn ($query, string $status) => $query->where('status', $status))
            ->when($filters['customer_value'] ?? null, fn ($query, string $value) => $query->whereHas('profile', fn ($profileQuery) => $profileQuery->where('customer_value', $value)))
            ->when($filters['industry'] ?? null, fn ($query, string $industry) => $query->whereHas('profile', fn ($profileQuery) => $profileQuery->where('industry', 'like', "%{$industry}%")))
            ->latest()
            ->paginate((int) $request->input('per_page', 12))
            ->withQueryString();

        return view('clients.index', [
            'clients' => $clients,
            'filters' => $filters,
        ]);
    }

    public function create(): View
    {
        return view('clients.create');
    }

    public function store(Request $request): RedirectResponse
    {
        [$clientData, $profileData] = $this->validated($request);
        $client = Client::create($clientData);
        $client->profile()->create($profileData);

        return redirect()->route('clients.show', $client)->with('status', 'Client created.');
    }

    public function show(Client $client): View
    {
        $client->load(['profile', 'projects.maintenanceReports']);

        return view('clients.show', ['client' => $client]);
    }

    public function edit(Client $client): View
    {
        $client->load('profile');

        return view('clients.edit', ['client' => $client]);
    }

    public function update(Request $request, Client $client): RedirectResponse
    {
        [$clientData, $profileData] = $this->validated($request);
        $client->update($clientData);
        $client->profile()->updateOrCreate(['client_id' => $client->id], $profileData);

        return redirect()->route('clients.show', $client)->with('status', 'Client updated.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'contact_name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'status' => ['required', 'in:active,inactive'],
            'short_code' => ['nullable', 'string', 'max:255'],
            'industry' => ['nullable', 'string', 'max:255'],
            'legal_form' => ['nullable', 'string', 'max:255'],
            'customer_since' => ['nullable', 'string', 'max:255'],
            'emails_text' => ['nullable', 'string'],
            'phones_text' => ['nullable', 'string'],
            'preferred_channel' => ['nullable', 'string', 'max:255'],
            'personal_notes' => ['nullable', 'string'],
        ]);

        $clientData = collect($data)->only([
            'company_name',
            'contact_name',
            'email',
            'phone',
            'address',
            'status',
        ])->all();

        $profileData = collect($data)->except([
            'company_name',
            'contact_name',
            'email',
            'phone',
            'address',
            'status',
            'emails_text',
            'phones_text',
        ])->all();

        $profileData['emails'] = $this->lines($data['emails_text'] ?? '');
        $profileData['phones'] = $this->lines($data['phones_text'] ?? '');

        return [$clientData, $profileData];
    }

    private function lines(?string $value): array
    {
        return collect(preg_split('/\r\n|\r|\n/', (string) $value))
            ->map(fn (string $line): string => trim($line))
            ->filter()
            ->values()
            ->all();
    }
}
