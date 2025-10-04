<x-guest-layout>
  <div class="min-h-screen bg-[#e9fbff] flex items-center px-4 py-8">
    <div class="container mx-auto w-full grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">

      {{-- Izquierda: imagen + marca --}}
      <div class="relative rounded-3xl overflow-hidden shadow-md order-1 lg:order-none">
        <img src="{{ asset('images/eco-hero.jpg') }}" alt="Eco Recolect"
             class="w-full h-80 sm:h-[28rem] lg:h-[36rem] object-cover">
        <div class="absolute top-4 left-4 flex items-center gap-2 bg-white/85 rounded-full px-3 py-1.5">
          <img src="{{ asset('images/logo-ecorecolect.png') }}"
               srcset="{{ asset('images/logo-ecorecolect.png') }} 1x,
                       {{ asset('images/logo-ecorecolect@2x.png') }} 2x,
                       {{ asset('images/logo-ecorecolect@3x.png') }} 3x"
               alt="Eco Recolect" class="h-7 w-auto">
          <span class="font-semibold">Eco Recolect</span>
        </div>
      </div>

      {{-- Derecha: tarjeta de registro (usuario) --}}
      <div class="w-full flex flex-col items-center">
        <p class="text-gray-700 mb-6 text-center text-sm sm:text-base">
          Sistema de Gestión de Residuos <br class="hidden sm:block"> Domésticos
        </p>

        <div class="w-full max-w-2xl bg-white rounded-2xl shadow-[0_15px_30px_rgba(0,0,0,0.15)] p-6 sm:p-10">
          <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-center leading-tight">Registro</h1>
          <p class="text-center text-gray-500 mt-1 mb-8">Crea tu cuenta personal</p>

          @if ($errors->any())
            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-700">
              <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <x-input-label for="first_name" :value="'Nombre'" />
                <x-text-input id="first_name" name="first_name" type="text"
                              class="block mt-1 w-full" :value="old('first_name')" required autofocus />
                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
              </div>
              <div>
                <x-input-label for="last_name" :value="'Apellido'" />
                <x-text-input id="last_name" name="last_name" type="text"
                              class="block mt-1 w-full" :value="old('last_name')" required />
                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
              </div>
            </div>

            <div>
              <x-input-label for="phone" :value="'Teléfono'" />
              <x-text-input id="phone" name="phone" type="text"
                            class="block mt-1 w-full" :value="old('phone')" required />
              <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>

            <div>
              <x-input-label for="email" :value="'Email'" />
              <x-text-input id="email" name="email" type="email"
                            class="block mt-1 w-full" :value="old('email')" required />
              <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
              <x-input-label for="address" :value="'Dirección'" />
              <x-text-input id="address" name="address" type="text"
                            class="block mt-1 w-full" :value="old('address')" required />
              <x-input-error :messages="$errors->get('address')" class="mt-2" />
            </div>

            <div>
              <x-input-label for="locality" :value="'Localidad'" />
              <select id="locality" name="locality" required
                      class="block mt-1 w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-3 focus:border-gray-500 focus:ring-0">
                <option value="">Selecciona...</option>
                @foreach ($localities as $loc)
                  <option value="{{ $loc }}" {{ old('locality')===$loc ? 'selected' : '' }}>
                    {{ $loc }}
                  </option>
                @endforeach
              </select>
              <x-input-error :messages="$errors->get('locality')" class="mt-2" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <x-input-label for="password" :value="'Contraseña'" />
                <x-text-input id="password" name="password" type="password"
                              class="block mt-1 w-full" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
              </div>
              <div>
                <x-input-label for="password_confirmation" :value="'Confirmar contraseña'" />
                <x-text-input id="password_confirmation" name="password_confirmation" type="password"
                              class="block mt-1 w-full" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
              </div>
            </div>

            <div class="flex items-center justify-between pt-2">
              <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                ¿Ya tienes cuenta? Iniciar sesión
              </a>
              <x-primary-button>Crear Cuenta</x-primary-button>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</x-guest-layout>
