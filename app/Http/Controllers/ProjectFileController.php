<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectFile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProjectFileController extends Controller
{
    public function store(Request $request, Project $project): RedirectResponse
    {
        $data = $request->validate([
            'entry_type' => ['required', 'in:file,note'],
            'file' => ['required_if:entry_type,file', 'file', 'max:2048'],
            'category' => ['required', 'in:'.implode(',', array_keys(ProjectFile::CATEGORIES))],
            'visibility' => ['required', 'in:internal,client'],
            'title' => ['required_if:entry_type,note', 'nullable', 'string', 'max:255'],
            'content' => ['required_if:entry_type,note', 'nullable', 'string'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        if ($data['entry_type'] === 'note') {
            $project->files()->create([
                'uploaded_by' => $request->user()->id,
                'entry_type' => 'note',
                'category' => $data['category'],
                'visibility' => $data['visibility'],
                'title' => $data['title'],
                'content' => $data['content'],
                'disk' => 'local',
                'size' => 0,
                'notes' => $data['notes'] ?? null,
            ]);

            return back()->with('status', 'Detail saved.');
        }

        $uploadedFile = $request->file('file');
        $path = null;

        if ($uploadedFile) {
            $extension = $uploadedFile->getClientOriginalExtension();
            $filename = Str::uuid().($extension ? '.'.$extension : '');
            $directory = 'projects/'.$project->id.'/'.$data['category'];
            $path = $uploadedFile->storeAs($directory, $filename, 'local');
        }

        $project->files()->create([
            'uploaded_by' => $request->user()->id,
            'entry_type' => 'file',
            'category' => $data['category'],
            'visibility' => $data['visibility'],
            'title' => $uploadedFile?->getClientOriginalName(),
            'original_name' => $uploadedFile?->getClientOriginalName(),
            'stored_path' => $path,
            'disk' => 'local',
            'mime_type' => $uploadedFile?->getMimeType(),
            'size' => $uploadedFile?->getSize() ?: 0,
            'notes' => $data['notes'] ?? null,
        ]);

        return back()->with('status', 'File uploaded.');
    }

    public function download(ProjectFile $projectFile): StreamedResponse
    {
        abort_unless($projectFile->entry_type === 'file' && $projectFile->stored_path, 404);
        abort_unless(Storage::disk($projectFile->disk)->exists($projectFile->stored_path), 404);

        return Storage::disk($projectFile->disk)->download($projectFile->stored_path, $projectFile->original_name);
    }

    public function destroy(ProjectFile $projectFile): RedirectResponse
    {
        if ($projectFile->stored_path) {
            Storage::disk($projectFile->disk)->delete($projectFile->stored_path);
        }

        $projectFile->delete();

        return back()->with('status', 'Item deleted.');
    }
}
