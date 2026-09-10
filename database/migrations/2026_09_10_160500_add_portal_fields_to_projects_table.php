<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table): void {
            $table->string('cms')->nullable()->after('type');
            $table->string('theme_builder')->nullable()->after('cms');
            $table->string('hosting')->nullable()->after('theme_builder');
            $table->string('domain_registrar')->nullable()->after('hosting');
            $table->string('maintenance_package')->nullable()->after('domain_registrar');
            $table->string('project_documents_url')->nullable()->after('maintenance_package');
            $table->string('project_images_url')->nullable()->after('project_documents_url');
            $table->string('access_vault_url')->nullable()->after('project_images_url');
            $table->text('requirements')->nullable()->after('notes');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table): void {
            $table->dropColumn([
                'cms',
                'theme_builder',
                'hosting',
                'domain_registrar',
                'maintenance_package',
                'project_documents_url',
                'project_images_url',
                'access_vault_url',
                'requirements',
            ]);
        });
    }
};
