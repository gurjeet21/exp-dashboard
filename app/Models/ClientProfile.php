<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientProfile extends Model
{
    protected $fillable = [
        'client_id',
        'short_code',
        'industry',
        'legal_form',
        'customer_since',
        'customer_value',
        'emails',
        'phones',
        'preferred_channel',
        'secondary_contact',
        'decision_maker',
        'availability',
        'project_types',
        'cms',
        'theme_builder',
        'hosting',
        'domain_registrar',
        'ssl_certificate',
        'customer_tools',
        'services_active',
        'services_potential',
        'tonality',
        'target_group',
        'primary_colors',
        'fonts',
        'logo_link',
        'brand_notes',
        'seo_checks',
        'main_keywords',
        'current_rankings',
        'last_seo_review',
        'seo_notes',
        'internal_owner',
        'satisfaction',
        'payment_behavior',
        'personal_notes',
        'internal_warnings',
        'last_updated_on',
        'last_updated_by',
    ];

    protected function casts(): array
    {
        return [
            'emails' => 'array',
            'phones' => 'array',
            'project_types' => 'array',
            'customer_tools' => 'array',
            'services_active' => 'array',
            'services_potential' => 'array',
            'seo_checks' => 'array',
            'last_updated_on' => 'date',
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
