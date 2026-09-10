<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'assigned_user_id',
        'name',
        'website_url',
        'type',
        'cms',
        'theme_builder',
        'hosting',
        'domain_registrar',
        'maintenance_package',
        'project_documents_url',
        'project_images_url',
        'access_vault_url',
        'status',
        'start_date',
        'monthly_price',
        'notes',
        'requirements',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'monthly_price' => 'decimal:2',
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    public function maintenanceReports(): HasMany
    {
        return $this->hasMany(MaintenanceReport::class);
    }
}
