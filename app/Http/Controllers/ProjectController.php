<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->only([
            'search',
            'client_id',
            'assigned_user_id',
            'status',
            'type',
            'start_from',
            'start_to',
        ]);

        $projects = Project::query()
            ->with(['client', 'assignedUser'])
            ->when($filters['search'] ?? null, function ($query, string $search): void {
                $query
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('website_url', 'like', "%{$search}%")
                    ->orWhereHas('client', fn ($clientQuery) => $clientQuery->where('company_name', 'like', "%{$search}%"));
            })
            ->when($filters['client_id'] ?? null, fn ($query, string $clientId) => $query->where('client_id', $clientId))
            ->when($filters['assigned_user_id'] ?? null, fn ($query, string $userId) => $query->where('assigned_user_id', $userId))
            ->when($filters['status'] ?? null, fn ($query, string $status) => $query->where('status', $status))
            ->when($filters['type'] ?? null, fn ($query, string $type) => $query->where('type', 'like', "%{$type}%"))
            ->when($filters['start_from'] ?? null, fn ($query, string $date) => $query->whereDate('start_date', '>=', $date))
            ->when($filters['start_to'] ?? null, fn ($query, string $date) => $query->whereDate('start_date', '<=', $date))
            ->latest()
            ->paginate((int) $request->input('per_page', 12))
            ->withQueryString();

        return view('projects.index', [
            'projects' => $projects,
            'clients' => Client::orderBy('company_name')->get(),
            'users' => User::orderBy('name')->get(),
            'filters' => $filters,
        ]);
    }

    public function create(): View
    {
        return view('projects.create', $this->formData());
    }

    public function store(Request $request): RedirectResponse
    {
        $project = Project::create($this->validated($request));

        return redirect()->route('projects.show', $project)->with('status', 'Project created.');
    }

    public function show(Project $project): View
    {
        $project->load(['client', 'assignedUser', 'maintenanceReports' => fn ($query) => $query->latest()]);

        return view('projects.show', ['project' => $project]);
    }

    public function edit(Project $project): View
    {
        return view('projects.edit', ['project' => $project] + $this->formData());
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $project->update($this->validated($request));

        return redirect()->route('projects.show', $project)->with('status', 'Project updated.');
    }

    private function formData(): array
    {
        return [
            'clients' => Client::orderBy('company_name')->get(),
            'users' => User::orderBy('name')->get(),
        ];
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'client_id' => ['required', 'exists:clients,id'],
            'assigned_user_id' => ['nullable', 'exists:users,id'],
            'name' => ['required', 'string', 'max:255'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:active,paused,completed'],
            'start_date' => ['nullable', 'date'],
            'monthly_price' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
        ]);
    }
}
