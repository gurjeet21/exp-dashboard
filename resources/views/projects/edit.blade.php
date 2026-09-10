<x-app-layout>
    <x-slot name="header"><h1 class="text-2xl font-semibold text-slate-950">Projekt bearbeiten</h1></x-slot>
    <div class="py-8"><div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">@include('projects.partials.form', ['project' => $project, 'action' => route('projects.update', $project), 'method' => 'PUT'])</div></div>
</x-app-layout>
