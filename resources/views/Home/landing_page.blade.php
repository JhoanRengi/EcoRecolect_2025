@extends('layouts.app')

@section('title', 'Inicio')

@section('content')

{{-- En tu plantilla principal o en la vista 'landing' --}}
@if (session('success'))
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    </div>
@endif

<link rel="stylesheet" href="{{ asset('css/landing_page.css') }}">

<div class="hero-section position-relative text-white d-flex align-items-center justify-content-start">
    
    <div class="container p-5" style="z-index: 10;">
        <div class="row">
            {{-- Columna para el texto (ocupa 8 de 12 columnas en pantallas grandes) --}}
            <div class="col-12 col-lg-8">
                
                <h1 class="display-2 fw-bolder mb-3 text-uppercase">TRANSFORMANDO TUS RESIDUOS</h1>
                
                <p class="lead fw-bold mb-4">Dile adiós al Desperdicio, Hola al Compostaje y Reciclaje Responsable.</p>

                <p class="mb-5 fs-5">Un servicio de recolección de residuos domésticos que va más allá, reduciendo la huella en los rellenos sanitarios y recompensando tu compromiso.</p>
                
                {{-- Botón Estilizado SIN Enlace de Laravel --}}
                <button
                    onclick="window.location='{{ route('register') }}'"
                    class="btn btn-dark btn-lg px-4 py-3 shadow-lg custom-btn-radius">
                    ¡Regístrate Hoy!
                    </button>
            </div>
        </div>
    </div>
</div>

    

</div>

<br>
<div class="container py-5 px-5">  
    <h1 class="text-center  mb-5">
        ¿Cansado de que tus residuos terminen en el mismo lugar? Descubre Eco Recolect
    </h1>
    <div class="row justify-content-center">
        
        <div class="col-12 col-md-6 col-lg-3 d-flex mb-4">
            <div class="card shadow-sm border-0 rounded-3 overflow-hidden w-100">
                
                {{-- Imagen que se ajusta --}}
                <img src="{{ asset('images/recoleccion_especializada.png') }}" class="card-img-top" alt="Recolección Especializada">
                
                <div class="card-body p-3 bg-white">
                    <h5 class="card-title fw-bold">RECOLECCIÓN ESPECIALIZADA</h5>
                    <p class="card-text small">
                        Residuos Orgánicos, Inorgánicos y Peligrosos.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-3 d-flex mb-4">
            <div class="card shadow-sm border-0 rounded-3 overflow-hidden w-100">
                <img src="{{ asset('images/impacto_real.png') }}" class="card-img-top" alt="Impacto Real">
                <div class="card-body p-3 bg-white">
                    <h5 class="card-title fw-bold">IMPACTO REAL</h5>
                    <p class="card-text small">
                        Menos residuos en rellenos sanitarios.
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-md-6 col-lg-3 d-flex mb-4">
            <div class="card shadow-sm border-0 rounded-3 overflow-hidden w-100">
                <img src="{{ asset('images/a_la_mano.png') }}" class="card-img-top" alt="A la Mano">
                <div class="card-body p-3 bg-white">
                    <h5 class="card-title fw-bold">A LA MANO</h5>
                    <p class="card-text small">
                        Programación flexible a tu medida.
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-md-6 col-lg-3 d-flex mb-4">
            <div class="card shadow-sm border-0 rounded-3 overflow-hidden w-100">
                <img src="{{ asset('images/recompensa.png') }}" class="card-img-top" alt="Recompensa">
                <div class="card-body p-3 bg-white">
                    <h5 class="card-title fw-bold">RECOMPENSA</h5>
                    <p class="card-text small">
                        Gana puntos y descuentos por tu esfuerzo.
                    </p>
                </div>
            </div>
        </div>
        
    </div>
</div>

{{-- Contenedor Principal con la Imagen de Fondo --}}
<div class="como-funciona-section position-relative py-5">
    
    {{-- Título flotante arriba a la izquierda --}}
    <div class="floating-title p-2 px-4 rounded-end fw-bold text-white fs-4">
        ¿Cómo funciona?
    </div>

    <div class="container my-5">
        <div class="row">
            
            {{-- Columna Izquierda (Imagen y Contenido Inferior) --}}
            <div class="col-12 col-lg-6 d-flex align-items-center justify-content-center">
                {{-- No colocamos nada aquí, la imagen es el fondo del div principal --}}
            </div>

            {{-- Columna Derecha (Los 4 Pasos del Proceso) --}}
            <div class="col-12 col-lg-6 py-5">
                
                <div class="paso-container">
                    
                    {{-- Paso 1: Únete a la Comunidad --}}
                    <div class="paso-box p-3 mb-4 rounded-3 text-white">
                        <h4 class="fw-bold">Paso 1: Únete a la Comunidad</h4>
                        <p class="mb-0">Suscripción gratuita y voluntaria.</p>
                    </div>
                    
                    {{-- Paso 2: Separa tus Residuos --}}
                    <div class="paso-box p-3 mb-4 rounded-3 text-white">
                        <h4 class="fw-bold">Paso 2: Separa tus Residuos</h4>
                        <p class="mb-0">Guías claras para orgánicos, reciclables y peligrosos.</p>
                    </div>

                    {{-- Paso 3: ¡Listo para Recolectar! --}}
                    <div class="paso-box p-3 mb-4 rounded-3 text-white">
                        <h4 class="fw-bold">Paso 3: ¡Listo para Recolectar!</h4>
                        <p class="mb-0">Programación de recolecciones.</p>
                    </div>

                    {{-- Paso 4: Transformación y Recompensa --}}
                    <div class="paso-box p-3 mb-4 rounded-3 text-white">
                        <h4 class="fw-bold">Paso 4: Transformación y Recompensa</h4>
                        <p class="mb-0">Lo que sucede con tus residuos y cómo ganas puntos.</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<br>
{{-- 1. Contenedor Principal con el Mapa de Fondo --}}
<div class="compromiso-section position-relative py-5 text-center">
    
    {{-- Título superior verde (se posiciona automáticamente sobre el mapa) --}}
    <h2 class="compromiso-title d-inline-block text-white px-5 py-2 rounded-pill mb-5">
        Tu Compromiso, Nuestra Recompensa, El Planeta Gana.
    </h2>

    <div class="container mt-5">
        <div class="row align-items-start">
            
            {{-- Columna Izquierda: Beneficios Personales --}}
            <div class="col-12 col-md-6 mb-5">
                <div class="beneficios-box border border-success p-4 mx-auto">
                    <h3 class="fw-bold mb-3 text-start">Beneficios Personales</h3>
                    <ul class="list-unstyled text-start">
                        <li class="mb-2"><strong>Puntos Eco:</strong> Gana puntos con cada recolección correcta.</li>
                        <li class="mb-2"><strong>Descuentos Exclusivos:</strong> Canjea tus puntos en tiendas asociadas.</li>
                        <li class="mb-2"><strong>Reportes Detallados:</strong> Monitorea tu impacto y recolecciones.</li>
                        <li class="mb-2"><strong>Comodidad:</strong> Recolecciones programadas o por demanda.</li>
                    </ul>
                </div>
            </div>

            {{-- Columna Derecha: Beneficios Ambientales --}}
            <div class="col-12 col-md-6 mb-5">
                <div class="beneficios-box border border-success p-4 mx-auto">
                    <h3 class="fw-bold mb-3 text-start">Beneficios Ambientales</h3>
                    <ul class="list-unstyled text-start">
                        <li class="mb-2"><strong>Menos Residuos:</strong> Reducción significativa en rellenos sanitarios.</li>
                        <li class="mb-2"><strong>Compostaje Local:</strong> Creación de abono orgánico para la tierra.</li>
                        <li class="mb-2"><strong>Reciclaje Efectivo:</strong> Nuevos materiales y menos extracción de recursos.</li>
                        <li class="mb-2"><strong>Manejo Seguro:</strong> Disposición responsable de residuos peligrosos.</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>
<section class="py-5 bg-white">
    <div class="container text-center">
        
        {{-- Título Principal --}}
        <h2 class="display-5 fw-bolder mb-2 text-success">CADA RESIDUO CUENTA:</h2>
        <h2 class="display-5 fw-bold mb-5 text-success">EL PODER DE TU SEPARACIÓN</h2>

        <div class="row justify-content-center">

            {{-- Columna 1: Residuos Orgánicos --}}
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="residuo-card rounded-3 overflow-hidden shadow-sm">
                    
                    {{-- Contenedor del Collage de Imágenes (Fondo o Múltiples <img>) --}}
                    <div class="collage-organicos">
                        {{-- NOTA: Lo más limpio es usar una imagen que ya sea el collage --}}
                        <img src="{{ asset('images/collage_organicos.jpg') }}" class="img-fluid" alt="Imágenes de residuos orgánicos y compostaje">
                    </div>
                    
                    {{-- Título Oscuro --}}
                    <div class="bg-dark text-white py-2 px-3">
                        <h4 class="mb-0 fw-bold fs-5">Residuos Orgánicos</h4>
                    </div>

                    {{-- Recuadro Verde de Descripción --}}
                    <div class="descripcion-box-verde text-white p-3">
                        <p class="small mb-0 text-start">
                            ¡Tus restos orgánicos se transforman en abono! Recogemos en baldes con aserrín, lo llevamos a plantas especiales y en 10-16 semanas, microorganismos crean compost nutritivo y no contaminante para la tierra. ¡Revoluciona tu jardín!
                        </p>
                    </div>

                </div>
            </div>

            {{-- Columna 2: Residuos Inorgánicos --}}
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="residuo-card rounded-3 overflow-hidden shadow-sm">
                    
                    <div class="collage-inorganicos">
                        <img src="{{ asset('images/collage_inorganicos.jpg') }}" class="img-fluid" alt="Imágenes de residuos inorgánicos y reciclaje">
                    </div>
                    
                    <div class="bg-dark text-white py-2 px-3">
                        <h4 class="mb-0 fw-bold fs-5">Residuos Inorgánicos</h4>
                    </div>

                    <div class="descripcion-box-verde text-white p-3">
                        <p class="small mb-0 text-start">
                            ¡Tus reciclables tienen una segunda vida! Papel, plástico, vidrio y metal van a plantas de reciclaje donde se clasifican y se convierten en materiales para construcción, textiles o nuevos productos. ¡Menos desechos, más recursos!
                        </p>
                    </div>

                </div>
            </div>

            {{-- Columna 3: Residuos Peligrosos --}}
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="residuo-card rounded-3 overflow-hidden shadow-sm">
                    
                    <div class="collage-peligrosos">
                        <img src="{{ asset('images/collage_peligrosos.jpg') }}" class="img-fluid" alt="Imágenes de residuos peligrosos y manejo experto">
                    </div>
                    
                    <div class="bg-dark text-white py-2 px-3">
                        <h4 class="mb-0 fw-bold fs-5">Residuos Peligrosos</h4>
                    </div>

                    <div class="descripcion-box-verde text-white p-3">
                        <p class="small mb-0 text-start">
                            ¡Manejo experto para lo delicado! Nuestros residuos peligrosos son tratados por especialistas que separan cada químico para un manejo seguro y responsable. Protegemos tu salud y el planeta de riesgos significativos.
                        </p>
                    </div>

                </div>
            </div>
            
        </div>
    </div>
</section>


@endsection