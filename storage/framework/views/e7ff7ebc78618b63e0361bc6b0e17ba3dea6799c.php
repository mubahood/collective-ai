<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale()), false); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token(), false); ?>">

    <title><?php echo e(config('app.name', 'Laravel'), false); ?></title>

    <!-- Scripts -->
    <script src="<?php echo e(asset('js/app.js'), false); ?>" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="<?php echo e(asset('css/app.css'), false); ?>" rel="stylesheet">
    <style>
        html, body {
           height: 100%;
        }
        
        body {
        margin: 0;
        padding: 0;
        }

        #app {
        min-height: 100vh;
        
        }
    
        main {
        text-align: center;
        }
        .input-icon {
            position: relative;
        }

        .input-icon .icon {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            right: 20px;
            
        }

        .input-icon .icon i {
            color: #444;
        }

        .input-icon .icon.show-password i {
            color: #444;
        }
    </style>
</head>
<body>
    <div id="app"  style="background: url(<?php echo e(asset('assets/images/gnut.jpg'), false); ?>) no-repeat;background-size: cover;">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="<?php echo e(url('/'), false); ?>">
                NARO GROUNDNUTS
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="<?php echo e(__('Toggle navigation'), false); ?>">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        <?php if(auth()->guard()->guest()): ?>
                            <?php if(Route::has('login')): ?>
                                <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(url('auth/login'), false); ?>"><?php echo e(__('Login'), false); ?></a>
                                </li>
                            <?php endif; ?>

                            <?php if(Route::has('register')): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo e(route('register'), false); ?>"><?php echo e(__('Register'), false); ?></a>
                                </li>
                            <?php endif; ?>
                        <?php else: ?>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <?php echo e(Auth::user()->name, false); ?>

                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="<?php echo e(route('logout'), false); ?>"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <?php echo e(__('Logout'), false); ?>

                                    </a>

                                    <form id="logout-form" action="<?php echo e(route('logout'), false); ?>" method="POST" class="d-none">
                                        <?php echo csrf_field(); ?>
                                    </form>
                                </div>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>
</body>
</html>
<?php /**PATH /Applications/MAMP/htdocs/naro-dashboard/resources/views/layouts/app.blade.php ENDPATH**/ ?>