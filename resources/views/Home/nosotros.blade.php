@extends('layouts.app') 

@section('title', 'Nosotros')

@section('content')

    
    {{-- 1. Hero / Título de la Sección --}}
    <div class="bg-light pt-5 pb-4 text-center nosotros-header">
        <div class="container">
            <h1 class="display-3 fw-bolder text-dark">Nuestra Historia Verde</h1>
            <p class="lead text-muted">Conoce el corazón y la visión que impulsan a EcoRecolect.</p>
        </div>
    </div>

    {{-- 2. Historia y Trayectoria --}}
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center">
                
                {{-- Bloque de Texto de Historia --}}
                <div class="col-lg-7 mb-4">
                    <h2 class="fw-bold mb-4 text-success">El Nacimiento de EcoRecolect</h2>
                    <p class="lead">
                        La idea de EcoRecolect nació de la frustración. Vimos cómo toneladas de residuos reciclables terminaban en rellenos sanitarios por falta de coordinación y acceso, mientras que los residuos orgánicos contaminaban, a pesar de ser una fuente potencial de vida. <br>
                    </p>
                    <p class="lead">
                    <strong>Nuestra Trayectoria:    </strong> Fundada en 2024 por un equipo de ingenieros ambientales y desarrolladores de software, iniciamos con una meta simple: usar la tecnología para conectar a las personas con un reciclaje y compostaje efectivo. Pasamos de ser un proyecto piloto en un barrio de Bogotá a expandirnos a tres ciudades clave, siempre enfocados en la educación y la recompensa al compromiso ambiental.
                    </p>
                    <p class="lead">
                    Desde entonces, hemos evolucionado nuestro modelo de gestión de residuos peligrosos, aliándonos con expertos químicos para garantizar un manejo responsable que protege tanto a nuestra comunidad como al planeta.
                    </p> 
                </div>
                
                {{-- Imagen o Carrusel del Equipo Fundador/Evolución --}}
                <div class="col-lg-5 mb-4">
                    <img src="{{ asset('img/equipo_fundador.jpg') }}" class="img-fluid rounded-3 shadow-lg" alt="Equipo fundador y proceso de reciclaje de EcoRecolect">
                </div>

            </div>
        </div>
    </section>

    {{-- 3. Misión y Visión (Componente de Tarjeta) --}}
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center fw-bold mb-5 text-dark">Nuestros Pilares</h2>
            <div class="row justify-content-center">
                
                {{-- Tarjeta de la Misión --}}
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-lg h-100 bg-success text-white">
                        <div class="card-body p-4">
                            <h3 class="card-title fw-bold mb-3">Misión</h3>
                            <p class="card-text fs-5">
                                Transformar la gestión de residuos domésticos en América Latina, ofreciendo soluciones tecnológicas que faciliten el compostaje, el reciclaje especializado y la disposición segura, creando un impacto ambiental y social positivo.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Tarjeta de la Visión --}}
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-lg h-100">
                        <div class="card-body p-4">
                            <h3 class="card-title fw-bold mb-3 text-success">Visión</h3>
                            <p class="card-text fs-5">
                                Ser la plataforma líder en sostenibilidad y recolección inteligente de residuos, reconocida por nuestra innovación tecnológica y por ser el motor clave en la reducción de la huella de carbono de las ciudades que servimos.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection

{{-- NOTA: Si necesitas estilos adicionales, añádelos a custom.css --}}