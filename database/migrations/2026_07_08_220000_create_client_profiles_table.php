<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('short_code')->nullable();
            $table->string('industry')->nullable();
            $table->string('legal_form')->nullable();
            $table->string('customer_since')->nullable();
            $table->string('customer_value')->nullable();
            $table->json('emails')->nullable();
            $table->json('phones')->nullable();
            $table->string('preferred_channel')->nullable();
            $table->string('secondary_contact')->nullable();
            $table->string('decision_maker')->nullable();
            $table->string('availability')->nullable();
            $table->json('project_types')->nullable();
            $table->string('cms')->nullable();
            $table->string('theme_builder')->nullable();
            $table->string('hosting')->nullable();
            $table->string('domain_registrar')->nullable();
            $table->string('ssl_certificate')->nullable();
            $table->json('customer_tools')->nullable();
            $table->json('services_active')->nullable();
            $table->json('services_potential')->nullable();
            $table->string('tonality')->nullable();
            $table->text('target_group')->nullable();
            $table->string('primary_colors')->nullable();
            $table->string('fonts')->nullable();
            $table->string('logo_link')->nullable();
            $table->text('brand_notes')->nullable();
            $table->json('seo_checks')->nullable();
            $table->text('main_keywords')->nullable();
            $table->text('current_rankings')->nullable();
            $table->string('last_seo_review')->nullable();
            $table->text('seo_notes')->nullable();
            $table->string('internal_owner')->nullable();
            $table->string('satisfaction')->nullable();
            $table->string('payment_behavior')->nullable();
            $table->text('personal_notes')->nullable();
            $table->text('internal_warnings')->nullable();
            $table->date('last_updated_on')->nullable();
            $table->string('last_updated_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_profiles');
    }
};
