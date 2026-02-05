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

<body class="bg-background-light dark:bg-background-dark font-display text-[#111418] dark:text-white">

  
  <?php echo $__env->make('layouts.sessions.header.top', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <div class="flex h-[calc(100vh-4rem)] overflow-hidden">

  
    <?php echo $__env->make('layouts.sessions.sidebar.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <main class="flex-1 overflow-y-auto">
      <?php echo $__env->yieldContent('content'); ?>
    </main>
  </div>
  
  
  <?php echo $__env->make('layouts.sessions.scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  
  <?php echo $__env->yieldPushContent('styles'); ?>
</body>

</html><?php /**PATH /home/sit27847/domains/sitelocationadviser.com/public_html/evaluation/resources/views/layouts/app.blade.php ENDPATH**/ ?>