@extends('layouts.app') 
@section('content')

    {{-- 1. Título Principal --}}
    <div class="container text-center py-5">
        <h1 class="display-4 fw-bolder text-dark">Nuestros Planes y Precios</h1>
        <p class="lead text-muted">Elige el plan que mejor se adapta a tus necesidades de recolección.</p>
    </div>

    {{-- 2. Sección de Planes y Precios (Inspirado en la imagen) --}}
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center fw-bold mb-5 text-dark">Planes y Precios</h2>
            
            <div class="row justify-content-center">
                
                {{-- Columna 1: Plan Básico --}}
                <div class="col-md-4 mb-4">
                    <div class="card pricing-card border-0 h-100 shadow-sm text-center">
                        <div class="card-body p-4">
                            <i class="fas fa-leaf fa-2x text-success mb-3"></i>
                            <h3 class="fw-bold mb-3 text-success">Plan Eco Básico</h3>

                            <div class="precio-box p-3 mb-4">
                                <span class="precio-monto display-5 fw-bold text-success">$39.900*</span>
                                <p class="mb-0 text-muted">Pago mensual</p>
                            </div>

                            <a class="text-info d-block mb-3" data-bs-toggle="collapse" href="#caracteristicasBasico" role="button" aria-expanded="false" aria-controls="caracteristicasBasico">
                                Características <i class="fas fa-chevron-down small"></i>
                            </a>

                            <div class="collapse" id="caracteristicasBasico">
                                <ul class="list-unstyled text-center small mt-3">
                                    <li><i class="fas fa-check-circle text-success me-2"></i> Recolección semanal de Orgánicos.</li>
                                    <li><i class="fas fa-check-circle text-success me-2"></i> 2 Recolecciones de Reciclables al mes.</li>
                                    <li><i class="fas fa-times-circle text-success me-2"></i> No incluye Residuos Peligrosos.</li>
                                    <li><i class="fas fa-check-circle text-success me-2"></i> Puntos Eco por cada recolección.</li>
                                </ul>
                            </div>

                            <button type="button" class="btn btn-success w-100 py-2 mt-4 obtener-btn">
                                Obtener ahora
                            </button>
                        </div>
                    </div>
                </div>
                
                {{-- Columna 2: Plan Premium --}}
                <div class="col-md-4 mb-4">
                    <div class="card pricing-card border-0 h-100 shadow-lg text-center plan-destacado">
                        <div class="card-body p-4">
                            <i class="fas fa-award fa-2x text-warning mb-3"></i>
                            <h3 class="fw-bold mb-3 text-success">Plan Eco Premium</h3>

                            <div class="precio-box p-3 mb-4">
                                <span class="precio-monto display-5 fw-bold text-success">$69.900*</span>
                                <p class="mb-0 text-muted">Pago mensual</p>
                            </div>

                            <a class="text-info d-block mb-3" data-bs-toggle="collapse" href="#caracteristicasPremium" role="button" aria-expanded="false" aria-controls="caracteristicasPremium">
                                Características <i class="fas fa-chevron-down small"></i>
                            </a>

                            <div class="collapse" id="caracteristicasPremium">
                                <ul class="list-unstyled text-center small mt-3">
                                    <li><i class="fas fa-check-circle text-success me-2"></i> Recolección 2 veces por semana.</li>
                                    <li><i class="fas fa-check-circle text-success me-2"></i> Incluye hasta 5Kg de Residuos Peligrosos.</li>
                                    <li><i class="fas fa-check-circle text-success me-2"></i> Descuentos exclusivos con aliados.</li>
                                    <li><i class="fas fa-check-circle text-success me-2"></i> Reportes detallados de tu impacto.</li>
                                </ul>
                            </div>

                            <button type="button" class="btn btn-success w-100 py-2 mt-4 obtener-btn">
                                Obtener ahora
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Columna 3: Plan Empresa --}}
                <div class="col-md-4 mb-4">
                    <div class="card pricing-card border-0 h-100 shadow-sm text-center">
                        <div class="card-body p-4">
                            <i class="fas fa-building fa-2x text-primary mb-3"></i>
                            <h3 class="fw-bold mb-3 text-success">Plan Eco Comercial</h3>

                            <div class="precio-box p-3 mb-4">
                                <span class="precio-monto display-5 fw-bold text-success">Cotizar</span>
                                <p class="mb-0 text-muted">Volumen y frecuencia a medida</p>
                            </div>

                            <a class="text-info d-block mb-3" data-bs-toggle="collapse" href="#caracteristicasComercial" role="button" aria-expanded="false" aria-controls="caracteristicasComercial">
                                Características <i class="fas fa-chevron-down small"></i>
                            </a>

                            <div class="collapse" id="caracteristicasComercial">
                                <ul class="list-unstyled text-center small mt-3">
                                    <li><i class="fas fa-check-circle text-success me-2"></i> Planes de volumen y frecuencia.</li>
                                    <li><i class="fas fa-check-circle text-success me-2"></i> Certificación de disposición final.</li>
                                    <li><i class="fas fa-check-circle text-success me-2"></i> Capacitación a empleados.</li>
                                    <li><i class="fas fa-check-circle text-success me-2"></i> Soporte dedicado 24/7.</li>
                                </ul>
                            </div>

                            <button type="button" class="btn btn-success w-100 py-2 mt-4 obtener-btn">
                                Contactar
                            </button>
                        </div>
                    </div>
                </div>

            </div>
            <p class="text-center small mt-4 text-muted"><strong>Los Precios varían según la ciudad.</strong></p>
        </div>
    </section>

    {{-- 3. Sección de Preguntas Frecuentes (FAQ) en Acordeón --}}
    <section class="py-5">
        <div class="container">
            <h2 class="text-center fw-bold mb-5">¿Tienes Alguna Duda?</h2>

            <div class="row">
                
                {{-- Columna Izquierda: Contacto (Inspirado en la imagen) --}}
                <div class="col-md-5 mb-4">
                    <div class="contacto-box bg-secondary p-5 rounded-3 text-white h-100">
                        <h3 class="fw-bold mb-4">¿No sabes qué servicio necesitas?</h3>
                        <p>Te ayudamos a encontrar el servicio a tu medida.</p>
                        <button type="button" class="btn btn-outline-light mt-3">Contáctanos</button>
                    </div>
                </div>

                {{-- Columna Derecha: Acordeón de Preguntas --}}
                <div class="col-md-7 mb-4">
                    <h4 class="fw-bold mb-4">Preguntas Frecuentes sobre EcoRecolect</h4>
                    
                    <div class="accordion" id="faqAccordion">
                        
                        {{-- Pregunta 1 --}}
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    ¿Cuál es el tiempo de entrega del sitio ya terminado?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Para nuestros planes de recolección, el servicio inicia una vez completado el pago y programada la primera recolección, usualmente dentro de las 72 horas siguientes.
                                </div>
                            </div>
                        </div>
                        
                        {{-- Pregunta 2 --}}
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    ¿Cuántas recolecciones incluye mi sitio?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Depende del plan que elijas. El Plan Básico incluye 4 recolecciones de orgánicos y 2 de reciclables al mes. Consulta los detalles de cada plan arriba.
                                </div>
                            </div>
                        </div>

                        {{-- Pregunta 3 --}}
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    ¿Qué tipo de cambios puedo solicitar en Soporte Técnico?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Nuestro soporte técnico está disponible para cambios de horarios, modificaciones en la dirección de recolección, y solución de problemas con la aplicación de puntos.
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
