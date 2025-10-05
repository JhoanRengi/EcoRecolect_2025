<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title'); ?> | EcoRecolect</title>
    <link rel="stylesheet" 
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
  <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css','resources/js/app.js']); ?>

</head>
<body>
    
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Logo" width="70" height="70" class="d-inline-block align-text-top">
            <a class="navbar-brand" href="/">EcoRecolect</a>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a href="/" class="nav-link">Inicio</a></li>
                <li class="nav-item"><a href="/nosotros" class="nav-link">Nosotros</a></li>
                <li class="nav-item"><a href="/planes" class="nav-link">Planes</a></li>
                <li class="nav-item"><a href="/contacto" class="nav-link">Contacto</a></li>
                 <?php if(auth()->guard()->check()): ?>
          <?php if(auth()->user()->user_type === 'admin'): ?>
            <li class="nav-item"><a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-link">Admin</a></li>
          <?php endif; ?>
          <li class="nav-item">
            <form method="POST" action="<?php echo e(route('logout')); ?>">
              <?php echo csrf_field(); ?>
              <button class="btn btn-link nav-link p-0">Cerrar sesión</button>
            </form>
          </li>
          <?php else: ?>
          <li class="nav-item"><a href="<?php echo e(route('login')); ?>" class="nav-link">Iniciar sesión</a></li>
          
        <?php endif; ?>
            </ul>
        </div>
    </nav>

   <main class="container-fluid p-0">
  <?php if(isset($slot)): ?>
    <?php echo e($slot); ?>             
  <?php else: ?>
    <?php echo $__env->yieldContent('content'); ?>       
  <?php endif; ?>
</main>

    
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
        <p>© <?php echo e(date('Y')); ?> EcoRecolect - Todos los derechos reservados.</p>
    </div>
</footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html><?php /**PATH /Users/carlo/Desktop/Programming Path 2025/Full-Stack Folder/EcoRecolect/EcoRecolect_2025/resources/views/layouts/app.blade.php ENDPATH**/ ?>