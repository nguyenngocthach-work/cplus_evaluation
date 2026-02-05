<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title><?php echo $__env->yieldContent('title', 'Auth'); ?></title>

  
  <?php echo $__env->make('layouts.sessions.styles', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  
  <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body class="bg-background-light dark:bg-background-dark font-display text-[#111418] dark:text-white">


  <?php echo $__env->yieldContent('content'); ?>

  
  <?php echo $__env->make('layouts.sessions.scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  
  <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html><?php /**PATH /home/sit27847/domains/sitelocationadviser.com/public_html/evaluation/resources/views/layouts/auth.blade.php ENDPATH**/ ?>