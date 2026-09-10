<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('project_files', function (Blueprint $table): void {
            $table->string('entry_type')->default('file')->after('uploaded_by');
            $table->string('title')->nullable()->after('visibility');
            $table->text('content')->nullable()->after('title');
            $table->string('original_name')->nullable()->change();
            $table->string('stored_path')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('project_files', function (Blueprint $table): void {
            $table->string('original_name')->nullable(false)->change();
            $table->string('stored_path')->nullable(false)->change();
            $table->dropColumn(['entry_type', 'title', 'content']);
        });
    }
};
