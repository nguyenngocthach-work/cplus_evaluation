<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title><?php echo $__env->yieldContent('title', 'App'); ?></title>

  
  <?php echo $__env->make('layouts.sessions.styles', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  
  <?php echo $__env->make('layouts.sessions.scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  
  <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body class="bg-background-light dark:bg-background-dark font-display text-[#111418] dark:text-white overflow-x-hidden">

  
  <?php echo $__env->make('layouts.sessions.header.top', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  <?php echo $__env->yieldContent('content'); ?>

  
  <?php echo $__env->make('layouts.sessions.scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  
  <?php echo $__env->yieldPushContent('styles'); ?>
</body>

</html><?php /**PATH D:\react\work\evaluation\evaluation\resources\views/layouts/app.blade.php ENDPATH**/ ?>