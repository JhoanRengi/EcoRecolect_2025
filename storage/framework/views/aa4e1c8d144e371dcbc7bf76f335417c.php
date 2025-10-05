<?php if (isset($component)) { $__componentOriginal69dc84650370d1d4dc1b42d016d7226b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b = $attributes; } ?>
<?php $component = App\View\Components\GuestLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\GuestLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="min-h-screen bg-[#e9fbff] flex items-center px-4 py-8">
        <div class="container mx-auto w-full grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">

            
            <div class="relative rounded-3xl overflow-hidden shadow-md order-1 lg:order-none">
                <img src="<?php echo e(asset('images/eco-hero.jpg')); ?>" alt="Eco Recolect"
                     class="w-full h-80 sm:h-[28rem] lg:h-[36rem] object-cover">
                <div class="absolute top-4 left-4 flex items-center gap-2 bg-white/85 rounded-full px-3 py-1.5">
                    <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Eco Recolect" class="h-4 w-4">
                    <span class="font-semibold">Eco Recolect</span>
                </div>
            </div>

            
            <div class="w-full flex flex-col items-center">
                <p class="text-gray-700 mb-6 text-center text-sm sm:text-base">
                    Sistema de Gestión de Residuos <br class="hidden sm:block"> Domésticos
                </p>

                <div class="w-full max-w-2xl bg-white rounded-2xl shadow-[0_15px_30px_rgba(0,0,0,0.15)] p-6 sm:p-10">
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-center leading-tight">Iniciar Sesión</h1>
                    <p class="text-center text-gray-500 mt-1 mb-8">Ingresa tus credenciales para acceder</p>

                    <?php if($errors->any()): ?>
                        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                            <ul class="list-disc pl-5">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-6">
                        <?php echo csrf_field(); ?>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus
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

                            <?php if(Route::has('password.request')): ?>
                                <a class="text-sm font-medium text-gray-600 hover:text-gray-900"
                                   href="<?php echo e(route('password.request')); ?>">¿Olvidaste tu contraseña?</a>
                            <?php endif; ?>
                        </div>

                        <button
                            class="w-full rounded-full bg-gray-700 px-6 py-3 text-lg font-semibold text-white shadow-md
                                   hover:opacity-95 active:scale-[.99] transition">
                            Iniciar Cuenta
                        </button>
                    </form>

                    <div class="mt-6 text-center text-sm text-gray-600">
                        ¿No tienes cuenta?
                        <a href="<?php echo e(route('register')); ?>" class="font-semibold text-gray-800 hover:underline">
                            Crear una cuenta
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $attributes = $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $component = $__componentOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php /**PATH /Users/carlo/Desktop/Programming Path 2025/Full-Stack Folder/EcoRecolect/EcoRecolect_2025/resources/views/auth/login.blade.php ENDPATH**/ ?>