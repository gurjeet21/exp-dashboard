<x-app-layout>
    <x-slot name="header"><h1 class="text-2xl font-semibold text-gray-950">Edit Project</h1></x-slot>
    <div class="py-8"><div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">@include('projects.partials.form', ['project' => $project, 'action' => route('projects.update', $project), 'method' => 'PUT'])</div></div>
</x-app-layout>
