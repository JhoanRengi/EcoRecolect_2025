<?php $__env->startSection('title', 'Contacto'); ?>
<?php $__env->startSection('content'); ?>

            <

<section class="contacto-section py-5">
    <div class="container py-5">
        
        
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <div class="row align-items-center">
            
            
            <div class="col-12 col-lg-5 mb-5 mb-lg-0">
                <div class="contacto-info text-dark p-4">
                    <h2 class="display-4 fw-bolder mb-3">Estamos aquí para ayudarte</h2>
                    <p class="lead mb-4">
                        ¿Tienes una pregunta sobre nuestros planes, necesitas soporte técnico o quieres cotizar un servicio comercial?
                    </p>
                    <p>
                        Rellena el formulario o escríbenos directamente. ¡Te responderemos lo antes posible!
                    </p>
                    
                    
                    <div class="mt-4">
                        <p class="mb-1"><i class="fas fa-envelope text-success me-2"></i> info@ecorecolect.com</p>
                        <p><i class="fas fa-phone-alt text-success me-2"></i> +57 300 123 4567</p>
                    </div>
                </div>
            </div>
            
            
            <div class="col-12 col-lg-7">
                
                <div class="formulario-box p-4 p-md-5 rounded-3 shadow-lg">
                    <h3 class="fw-bold mb-4 text-white">Envíanos un mensaje</h3>
                    
                    <form action="#" method="POST">
                        
                        <?php echo csrf_field(); ?> 
                        
                        
                        <div class="mb-3">
                            <input type="text" class="form-control custom-input" id="nombre" name="nombre" placeholder="Tu nombre" required>
                        </div>

                        
                        <div class="mb-3">
                            <input type="email" class="form-control custom-input" id="email" name="email" placeholder="Tu correo electrónico" required>
                        </div>
                        
                        
                        <div class="mb-3">
                            <input type="text" class="form-control custom-input" id="asunto" name="asunto" placeholder="Asunto (Cotización, Soporte, etc.)">
                        </div>
                        
                        
                        <div class="mb-4">
                            <textarea class="form-control custom-input" id="mensaje" name="mensaje" rows="4" placeholder="Cuéntanos tu proyecto o duda" required></textarea>
                        </div>
                        
                        
                        <button type="submit" class="btn btn-warning btn-lg fw-bold w-100 py-3">
                            Enviar Mensaje
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/carlo/Desktop/Programming Path 2025/Full-Stack Folder/EcoRecolect/EcoRecolect_2025/resources/views/home/contacto.blade.php ENDPATH**/ ?>