<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceReport;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class MaintenanceReportController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->only([
            'search',
            'status',
            'project_id',
            'year',
            'month',
            'date_from',
            'date_to',
        ]);

        $reports = MaintenanceReport::query()
            ->with('project.client')
            ->when($filters['search'] ?? null, function ($query, string $search): void {
                $query->whereHas('project', function ($projectQuery) use ($search): void {
                    $projectQuery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhereHas('client', fn ($clientQuery) => $clientQuery->where('company_name', 'like', "%{$search}%"));
                });
            })
            ->when($filters['status'] ?? null, fn ($query, string $status) => $query->where('status', $status))
            ->when($filters['project_id'] ?? null, fn ($query, string $projectId) => $query->where('project_id', $projectId))
            ->when($filters['year'] ?? null, fn ($query, string $year) => $query->whereYear('period_to', $year))
            ->when($filters['month'] ?? null, fn ($query, string $month) => $query->whereMonth('period_to', $month))
            ->when($filters['date_from'] ?? null, fn ($query, string $date) => $query->whereDate('period_to', '>=', $date))
            ->when($filters['date_to'] ?? null, fn ($query, string $date) => $query->whereDate('period_to', '<=', $date))
            ->latest()
            ->paginate((int) $request->input('per_page', 12))
            ->withQueryString();

        return view('reports.index', [
            'reports' => $reports,
            'projects' => Project::with('client')->orderBy('name')->get(),
            'filters' => $filters,
        ]);
    }

    public function create(Request $request): View
    {
        $project = $request->integer('project')
            ? Project::with('client')->find($request->integer('project'))
            : null;

        return view('reports.create', [
            'projects' => Project::with('client')->orderBy('name')->get(),
            'project' => $project,
            'report' => null,
            'defaults' => $this->defaults($project),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['created_by'] = $request->user()->id;
        $data['total_hours'] = $this->totalHours($data['time_items'] ?? []);
        $data['finalized_at'] = $data['status'] === 'final' ? now() : null;

        $report = MaintenanceReport::create($data);

        return redirect()->route('reports.show', $report)->with('status', 'Wartungsbericht gespeichert.');
    }

    public function show(MaintenanceReport $report): View
    {
        $report->load('project.client');

        return view('reports.show', ['report' => $report]);
    }

    public function edit(MaintenanceReport $report): View
    {
        $report->load('project.client');

        return view('reports.edit', [
            'projects' => Project::with('client')->orderBy('name')->get(),
            'project' => $report->project,
            'report' => $report,
            'defaults' => $this->defaults($report->project, $report),
        ]);
    }

    public function update(Request $request, MaintenanceReport $report): RedirectResponse
    {
        $data = $this->validated($request);
        $data['total_hours'] = $this->totalHours($data['time_items'] ?? []);
        $data['finalized_at'] = $data['status'] === 'final' ? ($report->finalized_at ?? now()) : null;

        $report->update($data);

        return redirect()->route('reports.show', $report)->with('status', 'Wartungsbericht aktualisiert.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'project_id' => ['required', 'exists:projects,id'],
            'status' => ['required', 'in:draft,final'],
            'period_from' => ['nullable', 'date'],
            'period_to' => ['nullable', 'date'],
            'caretaker' => ['nullable', 'string', 'max:255'],
            'system_items' => ['nullable', 'array'],
            'system_items.*.component' => ['nullable', 'string', 'max:255'],
            'system_items.*.status' => ['nullable', 'in:ok,updated,warn,err'],
            'system_items.*.note' => ['nullable', 'string'],
            'security_items' => ['nullable', 'array'],
            'security_items.*.measure' => ['nullable', 'string', 'max:255'],
            'security_items.*.status' => ['nullable', 'in:ok,updated,warn,err'],
            'security_items.*.note' => ['nullable', 'string'],
            'backup_items' => ['nullable', 'array'],
            'backup_items.*.period' => ['nullable', 'string', 'max:255'],
            'backup_items.*.result' => ['nullable', 'string', 'max:255'],
            'backup_items.*.status' => ['nullable', 'in:ok,updated,warn,err'],
            'uptime' => ['nullable', 'string', 'max:255'],
            'load_time' => ['nullable', 'string', 'max:255'],
            'pagespeed_desktop' => ['nullable', 'integer', 'min:0', 'max:100'],
            'pagespeed_mobile' => ['nullable', 'integer', 'min:0', 'max:100'],
            'optimizations' => ['nullable', 'string'],
            'errors' => ['nullable', 'string'],
            'time_items' => ['nullable', 'array'],
            'time_items.*.task' => ['nullable', 'string', 'max:255'],
            'time_items.*.hours' => ['nullable', 'numeric', 'min:0'],
            'notice' => ['nullable', 'string'],
            'contact_company' => ['nullable', 'string', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['nullable', 'email', 'max:255'],
        ]);
    }

    private function defaults(?Project $project = null, ?MaintenanceReport $report = null): array
    {
        $now = Carbon::now();

        return [
            'project_id' => $report?->project_id ?? $project?->id,
            'status' => $report?->status ?? 'draft',
            'period_from' => optional($report?->period_from)->format('Y-m-d') ?? $now->copy()->startOfMonth()->format('Y-m-d'),
            'period_to' => optional($report?->period_to)->format('Y-m-d') ?? $now->copy()->endOfMonth()->format('Y-m-d'),
            'caretaker' => $report?->caretaker ?? 'eXP Designs',
            'system_items' => $report?->system_items ?? [
                ['component' => 'WordPress Core', 'status' => 'ok', 'note' => ''],
                ['component' => 'Theme', 'status' => 'ok', 'note' => ''],
                ['component' => 'Plugins', 'status' => 'ok', 'note' => ''],
                ['component' => 'PHP-Version', 'status' => 'ok', 'note' => ''],
                ['component' => 'MySQL / Server', 'status' => 'ok', 'note' => ''],
                ['component' => 'Spamkontrolle', 'status' => 'ok', 'note' => ''],
            ],
            'security_items' => $report?->security_items ?? [
                ['measure' => 'Malware-Scan', 'status' => 'ok', 'note' => ''],
                ['measure' => 'Login-Versuche', 'status' => 'ok', 'note' => ''],
                ['measure' => 'Firewall / Schutzregeln', 'status' => 'ok', 'note' => ''],
                ['measure' => 'SPAM-Schutz', 'status' => 'ok', 'note' => ''],
                ['measure' => 'Sicherheits-Plugin', 'status' => 'ok', 'note' => ''],
            ],
            'backup_items' => $report?->backup_items ?? [
                ['period' => 'Monatlich (autom.)', 'result' => 'Erfolgreich', 'status' => 'ok'],
                ['period' => 'Letzter Restore-Test', 'result' => 'Funktioniert fehlerfrei', 'status' => 'ok'],
                ['period' => 'Speicherort', 'result' => 'Extern (Lokal / FTP)', 'status' => 'ok'],
            ],
            'uptime' => $report?->uptime ?? 'Keine vermerkten Ausfälle',
            'load_time' => $report?->load_time ?? '',
            'pagespeed_desktop' => $report?->pagespeed_desktop ?? null,
            'pagespeed_mobile' => $report?->pagespeed_mobile ?? null,
            'optimizations' => $report?->optimizations ?? "Caching\nMedienkomprimierung\nIndividuelle Codeoptimierungen",
            'errors' => $report?->errors ?? "Keine gravierenden Fehler im Error-Log\nKeine kaputten Links oder 404-Seiten erkannt\nLetzter Core Integrity Check: keine Abweichungen",
            'time_items' => $report?->time_items ?? [
                ['task' => 'Systemprüfung', 'hours' => 0.5],
                ['task' => 'Updates & Tests', 'hours' => 0.5],
                ['task' => 'Sicherheitschecks', 'hours' => 0.25],
                ['task' => 'Backup- und Wiederherstellungstest', 'hours' => 0.25],
                ['task' => 'Dokumentation', 'hours' => 0.25],
                ['task' => 'Kundengespräch', 'hours' => 1.0],
            ],
            'notice' => $report?->notice ?? 'Alle Wartungsmaßnahmen wurden nach aktuellem Stand der Technik durchgeführt. Wir empfehlen, die vorgeschlagenen Optimierungen zeitnah umzusetzen.',
            'contact_company' => $report?->contact_company ?? 'eXP Designs',
            'contact_phone' => $report?->contact_phone ?? '',
            'contact_email' => $report?->contact_email ?? 'gurjeet@expdesigns.de',
        ];
    }

    private function totalHours(array $items): float
    {
        return collect($items)->sum(fn (array $item): float => (float) ($item['hours'] ?? 0));
    }
}
