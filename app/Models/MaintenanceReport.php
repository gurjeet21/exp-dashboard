<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'created_by',
        'status',
        'period_from',
        'period_to',
        'caretaker',
        'system_items',
        'security_items',
        'backup_items',
        'uptime',
        'load_time',
        'pagespeed_desktop',
        'pagespeed_mobile',
        'optimizations',
        'errors',
        'time_items',
        'total_hours',
        'notice',
        'contact_company',
        'contact_phone',
        'contact_email',
        'finalized_at',
    ];

    protected function casts(): array
    {
        return [
            'period_from' => 'date',
            'period_to' => 'date',
            'system_items' => 'array',
            'security_items' => 'array',
            'backup_items' => 'array',
            'time_items' => 'array',
            'total_hours' => 'decimal:2',
            'finalized_at' => 'datetime',
        ];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
