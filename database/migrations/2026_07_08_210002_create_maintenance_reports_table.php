<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenance_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('status')->default('draft');
            $table->date('period_from')->nullable();
            $table->date('period_to')->nullable();
            $table->string('caretaker')->nullable();
            $table->json('system_items')->nullable();
            $table->json('security_items')->nullable();
            $table->json('backup_items')->nullable();
            $table->string('uptime')->nullable();
            $table->string('load_time')->nullable();
            $table->unsignedTinyInteger('pagespeed_desktop')->nullable();
            $table->unsignedTinyInteger('pagespeed_mobile')->nullable();
            $table->text('optimizations')->nullable();
            $table->text('errors')->nullable();
            $table->json('time_items')->nullable();
            $table->decimal('total_hours', 6, 2)->default(0);
            $table->text('notice')->nullable();
            $table->string('contact_company')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->timestamp('finalized_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_reports');
    }
};
