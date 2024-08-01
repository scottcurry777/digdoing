<?php $__env->startSection('content'); ?>
    
    <div style="
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        align-items: center;
        flex: 0 1 300px;
        width: 100%;
        margin-bottom: -100px;
        background-color: <?php echo e('#' . $location->color); ?>;
        <?php if($location->image): ?> background: url('<?php echo e($location->image); ?>'); <?php endif; ?>
        background-position: center;
        background-size: cover;
    ">
        <div style="
            flex: 0 1 250px;
            width: 100%;
            <?php if(Session::get('color_scheme') == 'light'): ?>
                background: linear-gradient(to bottom,
                    rgba(255,255,255,0.00) 0%,
                    rgba(255,255,255,0.05) 10%,
                    rgba(255,255,255,0.15) 20%,
                    rgba(255,255,255,0.28) 30%,
                    rgba(255,255,255,0.40) 40%,
                    rgba(255,255,255,0.60) 60%,
                    rgba(255,255,255,0.85) 80%,
                    rgba(255,255,255,1.00) 100%
                );
            <?php else: ?>
                background: linear-gradient(to bottom,
                    rgba(0,0,0,0.00) 0%,
                    rgba(0,0,0,0.05) 10%,
                    rgba(0,0,0,0.15) 20%,
                    rgba(0,0,0,0.28) 30%,
                    rgba(0,0,0,0.40) 40%,
                    rgba(0,0,0,0.60) 60%,
                    rgba(0,0,0,0.85) 80%,
                    rgba(0,0,0,1.00) 100%
                );
            <?php endif; ?>
        ">&nbsp;</div>
    </div>
        
    <div style="
        flex: 0 1 80px;
        width: 100%;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: stretch;
        flex-wrap: wrap;
    ">
        <div class="on-small-center-items" style="
            flex: 1 1 300px;
            margin-bottom: 10px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            align-items: flex-start;
        ">
            <div class="card-name on-small-center-text" style="text-align: left; text-shadow: none;
            margin: 0 10px;">
                <h1 style="font-size: inherit; font-weight: inherit; margin: 0;"><?php echo $__env->yieldContent('title'); ?></h1>
            </div>
            <div class="card-tag on-small-center-text" style="text-align: left; text-shadow: none;
            margin: 10px;">
                <?php echo e($location->country); ?>, <?php echo e($location->state); ?>

            </div>
        </div>
        <div class="on-small-center-items" style="
            flex: 1 1 300px;
            margin-bottom: 10px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            align-items: flex-end;
        ">
            <div class="on-small-center-text" style="
                text-align: right;
                margin: 0 10px 10px 10px;
            ">
                <?php echo e($location_interests->count()); ?> <?php if($location_interests->count() == 1): ?><?php echo e('Thing'); ?><?php else: ?><?php echo e('Things'); ?><?php endif; ?> to Do <?php echo e($location->adverb); ?> <?php echo e($location->name); ?>

            </div>
            <div class="on-small-center-text" style="
                display: flex;
                flex-direction: row;
                justify-content: flex-start;
                align-items: flex-end;
                text-align: right;
                height: 40px;
            ">
                <?php if(Session::get('color_scheme') == 'light'): ?>
                    <div class="nav-item" style="margin: 0 15px;">
                        <a href="/location/<?php echo e($location->country_fips); ?>/<?php echo e($location->state_fips); ?>/<?php echo e($location->slug); ?>/"><?php if(!isset(request()->segments()[4])): ?> <img src="/images/home_light_active.png" width="20px;" height="20px;"> <?php else: ?> <img src="/images/home_light.png" width="20px;" height="20px;"> <?php endif; ?></a>
                    </div>
                    <div class="nav-item" style="margin: 0 15px;">
                        <a href="/location/<?php echo e($location->country_fips); ?>/<?php echo e($location->state_fips); ?>/<?php echo e($location->slug); ?>/things-to-do/"><?php if((isset(request()->segments()[4])) && (request()->segments()[4] == 'things-to-do')): ?> <img src="/images/interests_light_active.png" width="20px;" height="20px;"> <?php else: ?> <img src="/images/interests_light.png" width="20px;" height="20px;"> <?php endif; ?></a>
                    </div>
                    <div class="nav-item" style="margin: 0 15px;">
                        <a href="/location/<?php echo e($location->country_fips); ?>/<?php echo e($location->state_fips); ?>/<?php echo e($location->slug); ?>/community/"><?php if((isset(request()->segments()[4])) && (request()->segments()[4] == 'community')): ?> <img src="/images/community_light_active.png" width="20px;" height="20px;"> <?php else: ?> <img src="/images/community_light.png" width="20px;" height="20px;"> <?php endif; ?></a>
                    </div>
                    <div class="nav-item" style="margin: 0 15px;">
                        <a href="/location/<?php echo e($location->country_fips); ?>/<?php echo e($location->state_fips); ?>/<?php echo e($location->slug); ?>/together/"><?php if((isset(request()->segments()[4])) && (request()->segments()[4] == 'together')): ?> <img src="/images/calendar_light_active.png" width="20px;" height="20px;"> <?php else: ?> <img src="/images/calendar_light.png" width="20px;" height="20px;"> <?php endif; ?></a>
                    </div>
                <?php else: ?>
                    <div class="nav-item" style="margin: 0 15px;">
                        <a href="/location/<?php echo e($location->country_fips); ?>/<?php echo e($location->state_fips); ?>/<?php echo e($location->slug); ?>/"><?php if(!isset(request()->segments()[4])): ?> <img src="/images/home_active.png" width="20px;" height="20px;"> <?php else: ?> <img src="/images/home.png" width="20px;" height="20px;"> <?php endif; ?></a>
                    </div>
                    <div class="nav-item" style="margin: 0 15px;">
                        <a href="/location/<?php echo e($location->country_fips); ?>/<?php echo e($location->state_fips); ?>/<?php echo e($location->slug); ?>/things-to-do/"><?php if((isset(request()->segments()[4])) && (request()->segments()[4] == 'things-to-do')): ?> <img src="/images/interests_active.png" width="20px;" height="20px;"> <?php else: ?> <img src="/images/interests.png" width="20px;" height="20px;"> <?php endif; ?></a>
                    </div>
                    <div class="nav-item" style="margin: 0 15px;">
                        <a href="/location/<?php echo e($location->country_fips); ?>/<?php echo e($location->state_fips); ?>/<?php echo e($location->slug); ?>/community/"><?php if((isset(request()->segments()[4])) && (request()->segments()[4] == 'community')): ?> <img src="/images/community_active.png" width="20px;" height="20px;"> <?php else: ?> <img src="/images/community.png" width="20px;" height="20px;"> <?php endif; ?></a>
                    </div>
                    <div class="nav-item" style="margin: 0 15px;">
                        <a href="/location/<?php echo e($location->country_fips); ?>/<?php echo e($location->state_fips); ?>/<?php echo e($location->slug); ?>/together/"><?php if((isset(request()->segments()[4])) && (request()->segments()[4] == 'together')): ?> <img src="/images/calendar_active.png" width="20px;" height="20px;"> <?php else: ?> <img src="/images/calendar.png" width="20px;" height="20px;"> <?php endif; ?></a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div style="
        flex: 1 1 100%;
        width: 100%;
        margin-top: 10px;
        display: flex;
        flex-flow: column wrap;
        align-items: center;
        justify-content: flex-start;
    ">
        <?php echo $__env->yieldContent('main-content'); ?>
    </div>
    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/scott4jesus/Websites/digdoing.com/resources/views/layouts/location.blade.php ENDPATH**/ ?>