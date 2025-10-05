<x-app-layout>
  <x-slot name="header"><h2 class="font-semibold text-xl">Panel de Administración</h2></x-slot>
  <div class="p-6">Bienvenido, {{ auth()->user()->name }} (admin).</div>
</x-app-layout>
