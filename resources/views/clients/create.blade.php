<x-app-layout>
    <x-slot name="header"><h1 class="text-2xl font-semibold text-gray-950">New Client</h1></x-slot>
    <div class="py-8"><div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">@include('clients.partials.form', ['client' => new \App\Models\Client(), 'action' => route('clients.store'), 'method' => 'POST'])</div></div>
</x-app-layout>
