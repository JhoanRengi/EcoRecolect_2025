<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | EcoRecolect</title>
    <link rel="stylesheet" 
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  @vite(['resources/css/app.css','resources/js/app.js'])

</head>
<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" width="70" height="70" class="d-inline-block align-text-top">
            <a class="navbar-brand" href="/">EcoRecolect</a>
            <ul class="hidden md:flex items-center gap-1 ms-auto">
              <li>
                <a href="{{ url('/') }}"
                   class="nav-link {{ request()->is('/') ? 'nav-link-active' : '' }}">
                  Inicio
                </a>
              </li>
              <li>
                <a href="{{ url('/nosotros') }}"
                   class="nav-link {{ request()->is('nosotros') ? 'nav-link-active' : '' }}">
                  Nosotros
                </a>
              </li>
              <li>
                <a href="{{ url('/planes') }}"
                   class="nav-link {{ request()->is('planes') ? 'nav-link-active' : '' }}">
                  Planes
                </a>
              </li>
              <li>
                <a href="{{ url('/contacto') }}"
                   class="nav-link {{ request()->is('contacto') ? 'nav-link-active' : '' }}">
                  Contacto
                </a>
              </li>

              @auth
                @php
                  $user = auth()->user();
                  $isAdmin = $user->user_type === 'admin';
                  $panelRoute = $isAdmin ? route('admin.dashboard') : route('user.dashboard');
                  $panelActive = $isAdmin ? request()->is('admin*') : request()->is('panel*');
                @endphp

                <li>
                  <a href="{{ $panelRoute }}"
                     title="Ir a tu panel"
                     class="nav-link {{ $panelActive ? 'nav-link-active' : '' }}">
                    Panel (Dashboard)
                  </a>
                </li>

                <li>
                  <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button class="nav-cta" type="submit">Cerrar sesión</button>
                  </form>
                </li>
              @else
                <li>
                  <a href="{{ route('login') }}" class="nav-cta nav-cta--primary">Ingresar</a>
                </li>
              @endauth
            </ul>
        </div>
    </nav>

   <main class="container-fluid p-0">
  @if (isset($slot))
    {{ $slot }}             {{-- funciona cuando usas <x-app-layout> --}}
  @else
    @yield('content')       {{-- funciona cuando usas @extends('layouts.app') --}}
  @endif
</main>

    {{-- Footer --}}
    <footer class="bg-success text-white text-center py-4 mt-5">
    <div class="container">
        <div class="row text-start"> <!-- text-start para alinear a la izquierda -->
        <div class="col">
            <h4 class="footer-title">Empresa</h4>
            <ul class="footer-list">
            <li><a href="#" class="footer-link">Sobre nosotros</a></li>
            <li><a href="#" class="footer-link">PQR</a></li>
            </ul>
        </div>

        <div class="col">
            <h4 class="footer-title">Ciudades</h4>
            <ul class="footer-list">
            <li>Bogotá</li>
            <li>Medellín</li>
            <li>Barranquilla</li>
            <li>Cali</li>
            </ul>
        </div>

        <div class="col">
            <h4 class="footer-title">Soporte</h4>
            <ul class="footer-list">
            <li><a href="#" class="footer-link">Centro de ayuda</a></li>
            <li><a href="#" class="footer-link">Contáctanos</a></li>
            </ul>
        </div>

        <div class="col">
            <h5 class="footer-title">Síguenos en nuestras redes sociales</h5>
            <div class="social-icons">
            🌿 🔗 💚
            </div>
        </div>
        </div>

        <hr class="my-4 border-light">
        <p>© {{ date('Y') }} EcoRecolect - Todos los derechos reservados.</p>
    </div>
</footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
