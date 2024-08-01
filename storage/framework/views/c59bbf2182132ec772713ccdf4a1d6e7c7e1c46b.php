<?php $__env->startSection('title'); ?>
<?php echo e($location->name); ?> Events
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>
    
    Events at this location (Calendar)
    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.location', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/scott4jesus/Websites/digdoing.com/resources/views/location/together.blade.php ENDPATH**/ ?>