<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectFile extends Model
{
    use HasFactory;

    public const CATEGORIES = [
        'documents' => 'Project Documents',
        'images' => 'Project Related Images',
        'maintenance_reports' => 'Maintenance Reports',
        'access' => 'Tresor / Zugangsdaten',
        'other' => 'Other',
    ];

    protected $fillable = [
        'project_id',
        'uploaded_by',
        'entry_type',
        'category',
        'visibility',
        'title',
        'content',
        'original_name',
        'stored_path',
        'disk',
        'mime_type',
        'size',
        'notes',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
