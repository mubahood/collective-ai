<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo e(config('admin.title'), false); ?> | <?php echo e(trans('admin.login'), false); ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <?php if(!is_null($favicon = Admin::favicon())): ?>
  <link rel="shortcut icon" href="<?php echo e($favicon, false); ?>">
  <?php endif; ?>

  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="<?php echo e(admin_asset("vendor/laravel-admin/AdminLTE/bootstrap/css/bootstrap.min.css"), false); ?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo e(admin_asset("vendor/laravel-admin/font-awesome/css/font-awesome.min.css"), false); ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo e(admin_asset("vendor/laravel-admin/AdminLTE/dist/css/AdminLTE.min.css"), false); ?>">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo e(admin_asset("vendor/laravel-admin/AdminLTE/plugins/iCheck/square/blue.css"), false); ?>">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="//oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page" style="background: url(<?php echo e(asset('assets/images/gnut.jpg'), false); ?>) no-repeat;background-size: cover;">
<nav class="navbar navbar-default" role="navigation" >
    <div class="container">
       <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbarSupportedContent" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="<?php echo e(url('/'), false); ?>">
       
        <span class="brand-text" style="font-size: 18px; font-weight: bold;">NARO GROUNDNUTS</span>
    </a>
</div>


        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                <?php if(auth()->guard()->guest()): ?>
                    <?php if(Route::has('login')): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(admin_url('auth/login'), false); ?>"><?php echo e(__('Login'), false); ?></a>
                        </li>
                    <?php endif; ?>

                    <?php if(Route::has('register')): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('register'), false); ?>"><?php echo e(__('Register'), false); ?></a>
                        </li>
                    <?php endif; ?>

                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<div class="login-box">
  <!-- /.login-logo -->
   
<div class="login-box-body" style="border: 3px solid green; border-radius: 25px;">
<div class="login-logo">
    <a href="<?php echo e(admin_url('/'), false); ?>">
    <img src="<?php echo e(asset('assets/images/logo.jpeg'), false); ?>" alt="Logo" style="max-width: 35%; height: 35%;">
    </a>
    
</div>
<?php if(Session::has('success')): ?>
                <div class="alert alert-success">
                    <?php echo e(Session::get('success'), false); ?>

                </div>
                <?php endif; ?>
                <?php if(Session::has('error')): ?>
                <div class="alert alert-danger">
                    <?php echo e(Session::get('error'), false); ?>

                </div>
                <?php endif; ?>

    <form action="<?php echo e(admin_url('auth/login'), false); ?>" method="post">
      <div class="form-group has-feedback <?php echo !$errors->has('username') ?: 'has-error'; ?>">

        <?php if($errors->has('username')): ?>
          <?php $__currentLoopData = $errors->get('username'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i><?php echo e($message, false); ?></label><br>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>

        <input type="text" class="form-control" placeholder="<?php echo e(trans('admin.username'), false); ?>" name="username" value="<?php echo e(old('username'), false); ?>">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback <?php echo !$errors->has('password') ?: 'has-error'; ?>">

        <?php if($errors->has('password')): ?>
          <?php $__currentLoopData = $errors->get('password'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i><?php echo e($message, false); ?></label><br>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>

        <input type="password" class="form-control" placeholder="<?php echo e(trans('admin.password'), false); ?>" name="password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <?php if(config('admin.auth.remember')): ?>
          <div class="checkbox icheck">
            <label>
              <input type="checkbox" name="remember" value="1" <?php echo e((!old('username') || old('remember')) ? 'checked' : '', false); ?>>
              <?php echo e(trans('admin.remember_me'), false); ?>

            </label>
          </div>
          <?php endif; ?>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <input type="hidden" name="_token" value="<?php echo e(csrf_token(), false); ?>">
          <button type="submit" class="btn btn-primary btn-block btn-flat"><?php echo e(trans('admin.login'), false); ?></button>
        </div>
        <!-- /.col -->
      </div>
    </form>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.1.4 -->
<script src="<?php echo e(admin_asset("vendor/laravel-admin/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js"), false); ?>"></script>
<!-- Bootstrap 3.3.5 -->
<script src="<?php echo e(admin_asset("vendor/laravel-admin/AdminLTE/bootstrap/js/bootstrap.min.js"), false); ?>"></script>
<!-- iCheck -->
<script src="<?php echo e(admin_asset("vendor/laravel-admin/AdminLTE/plugins/iCheck/icheck.min.js"), false); ?>"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
<?php /**PATH /Applications/MAMP/htdocs/naro-dashboard/vendor/encore/laravel-admin/src/../resources/views/login.blade.php ENDPATH**/ ?>