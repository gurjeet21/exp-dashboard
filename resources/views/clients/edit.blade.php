<x-app-layout>
    <x-slot name="header"><h1 class="text-2xl font-semibold text-slate-950">Kunde bearbeiten</h1></x-slot>
    <div class="py-8"><div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">@include('clients.partials.form', ['client' => $client, 'action' => route('clients.update', $client), 'method' => 'PUT'])</div></div>
</x-app-layout>
