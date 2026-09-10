<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Project;
use App\Models\ProjectFile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProjectFileTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_upload_a_project_file(): void
    {
        Storage::fake('local');

        $user = User::factory()->create();
        $project = Project::create([
            'client_id' => Client::create(['company_name' => 'Test Client', 'status' => 'active'])->id,
            'name' => 'Website Care',
            'type' => 'maintenance',
            'status' => 'active',
        ]);

        $response = $this->actingAs($user)->post(route('projects.files.store', $project), [
            'entry_type' => 'file',
            'file' => UploadedFile::fake()->create('briefing.pdf', 128, 'application/pdf'),
            'category' => 'documents',
            'visibility' => 'client',
            'notes' => 'Client briefing document.',
        ]);

        $response->assertRedirect();

        $file = ProjectFile::first();

        $this->assertSame('file', $file->entry_type);
        $this->assertSame('briefing.pdf', $file->original_name);
        $this->assertSame('documents', $file->category);
        $this->assertSame('client', $file->visibility);
        Storage::disk('local')->assertExists($file->stored_path);
    }

    public function test_user_can_save_a_written_project_detail(): void
    {
        Storage::fake('local');

        $user = User::factory()->create();
        $project = Project::create([
            'client_id' => Client::create(['company_name' => 'Test Client', 'status' => 'active'])->id,
            'name' => 'Website Care',
            'type' => 'maintenance',
            'status' => 'active',
        ]);

        $response = $this->actingAs($user)->post(route('projects.files.store', $project), [
            'entry_type' => 'note',
            'title' => 'Hosting access note',
            'content' => 'Client confirmed all-inkl account ownership.',
            'category' => 'access',
            'visibility' => 'internal',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('project_files', [
            'project_id' => $project->id,
            'entry_type' => 'note',
            'title' => 'Hosting access note',
            'category' => 'access',
            'visibility' => 'internal',
            'stored_path' => null,
        ]);
    }
}
