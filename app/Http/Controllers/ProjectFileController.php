<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectFile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProjectFileController extends Controller
{
    public function store(Request $request, Project $project): RedirectResponse
    {
        $data = $request->validate([
            'entry_type' => ['required', 'in:file,note'],
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

        if (! $uploadedFile) {
            return back()
                ->withErrors(['file' => 'No file was received by the server. Please choose the file again and upload.'])
                ->withInput($request->except('file'));
        }

        if (! $uploadedFile->isValid()) {
            return back()
                ->withErrors(['file' => 'Upload failed before Laravel could store it. PHP error '.$uploadedFile->getError().': '.$uploadedFile->getErrorMessage()])
                ->withInput($request->except('file'));
        }

        Validator::make(
            ['file' => $uploadedFile],
            ['file' => ['file', 'max:2048']]
        )->validate();

        $extension = $uploadedFile->getClientOriginalExtension();
        $filename = Str::uuid().($extension ? '.'.$extension : '');
        $directory = 'projects/'.$project->id.'/'.$data['category'];
        $path = $uploadedFile->storeAs($directory, $filename, 'local');

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

    public function edit(ProjectFile $projectFile): View
    {
        $projectFile->load('project.client');

        return view('project-files.edit', ['projectFile' => $projectFile]);
    }

    public function update(Request $request, ProjectFile $projectFile): RedirectResponse
    {
        $data = $request->validate([
            'category' => ['required', 'in:'.implode(',', array_keys(ProjectFile::CATEGORIES))],
            'visibility' => ['required', 'in:internal,client'],
            'title' => ['nullable', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        if ($projectFile->entry_type === 'note') {
            $request->validate([
                'title' => ['required', 'string', 'max:255'],
                'content' => ['required', 'string'],
            ]);
        }

        $projectFile->update([
            'category' => $data['category'],
            'visibility' => $data['visibility'],
            'title' => $data['title'] ?: $projectFile->original_name,
            'content' => $projectFile->entry_type === 'note' ? $data['content'] : null,
            'notes' => $data['notes'] ?? null,
        ]);

        return redirect()
            ->route('projects.show', $projectFile->project)
            ->with('status', 'Item updated.');
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
