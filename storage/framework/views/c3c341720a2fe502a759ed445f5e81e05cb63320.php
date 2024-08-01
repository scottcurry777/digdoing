<?php $__env->startSection('title', 'What do you dig doing?'); ?>

<?php $__env->startSection('content'); ?>
    
    Welcome, Logged In User!
	
	<div id="app"></div>
	<script src="<?php echo e(secure_asset('js/app.js')); ?>"></script>
    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/scott4jesus/Websites/digdoing.com/resources/views/home.blade.php ENDPATH**/ ?>