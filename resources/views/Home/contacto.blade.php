@extends('layouts.app')
@section('content')

            <

<section class="contacto-section py-5">
    <div class="container py-5">
        {{-- BLOQUE PARA MOSTRAR EL MENSAJE DE ÉXITO --}}
        {{-- Verifica si existe una variable de sesión llamada 'success' --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        {{-- FIN DEL BLOQUE DE MENSAJE --}}
        <div class="row align-items-center">
            
            {{-- Columna Izquierda: Información / Ilustración --}}
            <div class="col-12 col-lg-5 mb-5 mb-lg-0">
                <div class="contacto-info text-dark p-4">
                    <h2 class="display-4 fw-bolder mb-3">Estamos aquí para ayudarte</h2>
                    <p class="lead mb-4">
                        ¿Tienes una pregunta sobre nuestros planes, necesitas soporte técnico o quieres cotizar un servicio comercial?
                    </p>
                    <p>
                        Rellena el formulario o escríbenos directamente. ¡Te responderemos lo antes posible!
                    </p>
                    
                    {{-- Opcional: Iconos de Contacto --}}
                    <div class="mt-4">
                        <p class="mb-1"><i class="fas fa-envelope text-success me-2"></i> info@ecorecolect.com</p>
                        <p><i class="fas fa-phone-alt text-success me-2"></i> +57 300 123 4567</p>
                    </div>
                </div>
            </div>
            
            {{-- Columna Derecha: Formulario de Contacto --}}
            <div class="col-12 col-lg-7">
                {{-- La clase 'formulario-box' usará CSS personalizado para el fondo oscuro/translúcido --}}
                <div class="formulario-box p-4 p-md-5 rounded-3 shadow-lg">
                    <h3 class="fw-bold mb-4 text-white">Envíanos un mensaje</h3>
                    
                    <form action="#" method="POST">
                        {{-- Laravel CSRF Protection (Siempre incluir en formularios POST) --}}
                        @csrf 
                        
                        {{-- Campo Nombre --}}
                        <div class="mb-3">
                            <input type="text" class="form-control custom-input" id="nombre" name="nombre" placeholder="Tu nombre" required>
                        </div>

                        {{-- Campo Email --}}
                        <div class="mb-3">
                            <input type="email" class="form-control custom-input" id="email" name="email" placeholder="Tu correo electrónico" required>
                        </div>
                        
                        {{-- Campo Asunto --}}
                        <div class="mb-3">
                            <input type="text" class="form-control custom-input" id="asunto" name="asunto" placeholder="Asunto (Cotización, Soporte, etc.)">
                        </div>
                        
                        {{-- Campo Mensaje --}}
                        <div class="mb-4">
                            <textarea class="form-control custom-input" id="mensaje" name="mensaje" rows="4" placeholder="Cuéntanos tu proyecto o duda" required></textarea>
                        </div>
                        
                        {{-- Botón de Enviar --}}
                        <button type="submit" class="btn btn-warning btn-lg fw-bold w-100 py-3">
                            Enviar Mensaje
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection