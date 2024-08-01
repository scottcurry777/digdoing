<?php $__env->startSection('title'); ?>
<?php echo e($location->name); ?> Reviews
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>
    
    Community Reviews and Discussion Posts, Can be filtered by Interest
    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.location', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/scott4jesus/Websites/digdoing.com/resources/views/location/community.blade.php ENDPATH**/ ?>