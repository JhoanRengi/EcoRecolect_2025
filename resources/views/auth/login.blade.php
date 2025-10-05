<x-guest-layout>
    <div class="min-h-screen bg-[#e9fbff] flex items-center px-4 py-8">
        <div class="container mx-auto w-full grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">

            {{-- Panel izquierdo (imagen) - se muestra en md+; en móvil va arriba --}}
            <div class="relative rounded-3xl overflow-hidden shadow-md order-1 lg:order-none">
                <img src="{{ asset('images/eco-hero.jpg') }}" alt="Eco Recolect"
                     class="w-full h-80 sm:h-[28rem] lg:h-[36rem] object-cover">
                <div class="absolute top-4 left-4 flex items-center gap-2 bg-white/85 rounded-full px-3 py-1.5">
                    <img src="{{ asset('images/logo.png') }}" alt="Eco Recolect" class="h-4 w-4">
                    <span class="font-semibold">Eco Recolect</span>
                </div>
            </div>

            {{-- Panel derecho (formulario) --}}
            <div class="w-full flex flex-col items-center">
                <p class="text-gray-700 mb-6 text-center text-sm sm:text-base">
                    Sistema de Gestión de Residuos <br class="hidden sm:block"> Domésticos
                </p>

                <div class="w-full max-w-2xl bg-white rounded-2xl shadow-[0_15px_30px_rgba(0,0,0,0.15)] p-6 sm:p-10">
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-center leading-tight">Iniciar Sesión</h1>
                    <p class="text-center text-gray-500 mt-1 mb-8">Ingresa tus credenciales para acceder</p>

                    @if ($errors->any())
                        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                   placeholder="tucorreo@email.com"
                                   class="mt-1 w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-3
                                          focus:border-gray-500 focus:ring-0" />
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                            <input id="password" type="password" name="password" required autocomplete="current-password"
                                   placeholder="••••••••"
                                   class="mt-1 w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-3
                                          focus:border-gray-500 focus:ring-0" />
                        </div>

                        <div class="flex items-center justify-between flex-wrap gap-3">
                            <label class="inline-flex items-center gap-2 text-sm text-gray-600">
                                <input type="checkbox" name="remember"
                                       class="rounded border-gray-300 text-gray-700 focus:ring-gray-500">
                                Recuérdame
                            </label>

                            @if (Route::has('password.request'))
                                <a class="text-sm font-medium text-gray-600 hover:text-gray-900"
                                   href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                            @endif
                        </div>

                        <button
                            class="w-full rounded-full bg-gray-700 px-6 py-3 text-lg font-semibold text-white shadow-md
                                   hover:opacity-95 active:scale-[.99] transition">
                            Iniciar Cuenta
                        </button>
                    </form>

                    <div class="mt-6 text-center text-sm text-gray-600">
                        ¿No tienes cuenta?
                        <a href="{{ route('register') }}" class="font-semibold text-gray-800 hover:underline">
                            Crear una cuenta
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-guest-layout>
