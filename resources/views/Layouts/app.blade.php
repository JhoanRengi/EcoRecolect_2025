<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" 
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">


</head>
<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/">EcoRecolect</a>
            <img src="" alt="">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a href="/" class="nav-link">Inicio</a></li>
                <li class="nav-item"><a href="/nosotros" class="nav-link">Nosotros</a></li>
                <li class="nav-item"><a href="/planes" class="nav-link">Planes</a></li>
                <li class="nav-item"><a href="/contacto" class="nav-link">Contacto</a></li>
            </ul>
        </div>
    </nav>

    {{-- Aquí se inyectan las vistas --}}
    <div class="container-fluid p-0">
        @yield('content')
    </div>

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