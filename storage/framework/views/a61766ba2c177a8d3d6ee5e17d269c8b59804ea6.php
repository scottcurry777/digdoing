<?php $__env->startSection('title'); ?>
<?php echo e($location->name); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>

    <div>
        <?php echo e($location->description); ?>

    </div>
    
    Main Body
    
    
    
    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.location', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/scott4jesus/Websites/digdoing.com/resources/views/location/location.blade.php ENDPATH**/ ?>