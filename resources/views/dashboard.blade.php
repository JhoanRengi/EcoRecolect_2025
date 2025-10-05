<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl">Dashboard de Usuario</h2>
  </x-slot>

  <div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white shadow rounded-lg p-6">
        <p class="mb-2">Hola, {{ auth()->user()->name }} 👋</p>
        <p class="text-sm text-gray-600">Este es un panel temporal para usuarios.</p>

        <div class="mt-6 flex items-center gap-4">
          @if(auth()->user()->user_type === 'admin')
            <a href="{{ route('admin.dashboard') }}"
               class="px-4 py-2 rounded bg-gray-800 text-white hover:opacity-95">
              Ir al Panel Admin
            </a>
          @endif

          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="underline text-sm">Cerrar sesión</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>