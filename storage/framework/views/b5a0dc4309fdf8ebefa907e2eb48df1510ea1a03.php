<?php $__env->startSection('title'); ?>
Things to Do <?php echo e($location->adverb); ?> <?php echo e($location->name); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>



    <!-- <pre style="text-align: left;"><?php print_r($location_interests) ?></pre> -->
    
    
    <div class="card-container">
        <?php $__currentLoopData = $location_interests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location_interest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="card card-small link card-interest" onclick="location.href='/<?php echo e($location_interest->slug); ?>/discussion/<?php echo e($location->country_fips); ?>/<?php echo e($location->state_fips); ?>/<?php echo e($location->slug); ?>/';" style="
                position: relative;
                <?php if($location_interest->image): ?> background-image: url('<?php echo e($location_interest->image); ?>'); <?php else: ?> background: #<?php echo substr(dechex(crc32($location_interest->slug)), 0, 6); ?>; <?php endif; ?>
                
                <?php if($location_interest->userJoined): ?>
                    margin-bottom: 110px;
                <?php endif; ?>
            ">
                <div style="
                    position: absolute;
                    top: 0;
                    height: 170px;
                    width: 100%;
                    <?php if(Session::get('color_scheme') == 'light'): ?>
                        background: linear-gradient(to top, rgba(255,255,255,0) 0%, rgba(255,255,255,0.1) 20%, rgba(255,255,255,0.25) 40%, rgba(255,255,255,0.5) 60%, rgba(255,255,255,0.8) 80%, rgba(255,255,255,1) 100%);
                    <?php else: ?>
                        background: linear-gradient(to top, rgba(0,0,0,0) 0%, rgba(0,0,0,0.1) 20%, rgba(0,0,0,0.25) 40%, rgba(0,0,0,0.5) 60%, rgba(0,0,0,0.8) 80%, rgba(0,0,0,1) 100%);
                    <?php endif; ?>
                ">&nbsp;</div>
                <div class="card-name" style="z-index: 10;">
                    <?php echo e($location_interest->name); ?>

                </div>
                <div class="card-tag" style="
                    z-index: 10;
                    position: absolute;
                    bottom: 0;
                    right: 0;
                    height: initial;
                    padding: 3px 6px;
                    font-size: 1em;
                    text-align: right;
                    <?php if(Session::get('color_scheme') == 'light'): ?>
                        background: rgba(255,255,255,0.9);
                    <?php else: ?>
                        background: rgba(0,0,0,0.9);
                    <?php endif; ?>
                    border-radius: 5px 0px 0px 0px;
                ">
                    <?php if(!$location_interest->rating): ?>
                        <span style="font-size: 0.7em;">Not Yet Rated</span>
                    <?php else: ?>
                        <div style="float: left;">
                            <span style="font-size: 0.7em;"><?php echo e($location_interest->rating); ?> / 5.00</span><br>
                            <?php if($location_interest->rating < 1): ?>
                                Not Recommended
                            <?php elseif($location_interest->rating < 2): ?>
                                Not Great
                            <?php elseif($location_interest->rating < 3): ?>
                                It's OK
                            <?php elseif($location_interest->rating < 4): ?>
                                Recommended
                            <?php else: ?>
                                Highly Recommended
                            <?php endif; ?>
                        </div>
                        <div style="
                            float: right;
                            padding: 3px 0 3px 6px;
                        ">
                            <?php if(Session::get('color_scheme') == 'light'): ?>
                                <?php if($location_interest->rating < 1): ?>
                                    <img src="/images/ratings/rating_bad_light.png" width="30" height="30">
                                <?php elseif($location_interest->rating < 2): ?>
                                    <img src="/images/ratings/rating_bad_light.png" width="30" height="30">
                                <?php elseif($location_interest->rating < 3): ?>
                                    <img src="/images/ratings/rating_neutral_light.png" width="30" height="30">
                                <?php elseif($location_interest->rating < 4): ?>
                                    <img src="/images/ratings/rating_good_light.png" width="30" height="30">
                                <?php else: ?>
                                    <img src="/images/ratings/rating_good_light.png" width="30" height="30">
                                <?php endif; ?>
                            <?php else: ?>
                                <?php if($location_interest->rating < 1): ?>
                                    <img src="/images/ratings/rating_bad.png" width="30" height="30">
                                <?php elseif($location_interest->rating < 2): ?>
                                    <img src="/images/ratings/rating_bad.png" width="30" height="30">
                                <?php elseif($location_interest->rating < 3): ?>
                                    <img src="/images/ratings/rating_neutral.png" width="30" height="30">
                                <?php elseif($location_interest->rating < 4): ?>
                                    <img src="/images/ratings/rating_good.png" width="30" height="30">
                                <?php else: ?>
                                    <img src="/images/ratings/rating_good.png" width="30" height="30">
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <?php if($location_interest->userJoined): ?>
                    <div class="ratings" style="
                        position: absolute;
                        width: 100%;
                        height: 30px;
                        bottom: -40px;
                        display: flex; /* flex or none */
                        flex-flow: row wrap;
                        justify-content: space-evenly;
                    ">
                        <div style="
                            flex: 1 1 100%;
                            margin-bottom: 10px;
                            font-size: 0.9em;
                        ">
                            How is <?php echo e($location_interest->name); ?> at <?php echo e($location->name); ?>? <?php if(isset($location_interest->vote)): ?> <br><span style="font-weight: 700;">You Rated It</span> <?php endif; ?>
                        </div>
                        <div style="width: 60px; font-size: 0.7em;">
                            <!-- TODO: ON CLICK, add one to thumbs down -->
                            <!-- TODO: ON CLICK, recalculate rating ((thumbs up / total votes) * 5) -->
                            <?php if(Session::get('color_scheme') == 'light'): ?>
                                <?php if((isset($location_interest->vote)) and ($location_interest->vote != 'bad')): ?>
                                    <!-- TODO: ON HOVER, SHOW LIGHT -->
                                    <img src="/images/ratings/rating_bad.png" width="30" height="30" style="margin-bottom: 5px;"><br><span style="color: #d8d8d8;">Terrible</span>
                                <?php else: ?>
                                    <img src="/images/ratings/rating_bad_light.png" width="30" height="30" style="margin-bottom: 5px;"><br>Terrible
                                <?php endif; ?>
                            <?php else: ?>
                                <?php if((isset($location_interest->vote)) and ($location_interest->vote != 'bad')): ?>
                                    <!-- TODO: ON HOVER, SHOW DARK -->
                                    <img src="/images/ratings/rating_bad_light.png" width="30" height="30" style="margin-bottom: 5px;"><br><span style="color: #1a1a1a;">Terrible</span>
                                <?php else: ?>
                                    <img src="/images/ratings/rating_bad.png" width="30" height="30" style="margin-bottom: 5px;"><br>Terrible
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <div style="width: 60px; font-size: 0.7em;">
                            <!-- TODO: ON CLICK, add one to thumbs up AND one to thumbs down -->
                            <!-- TODO: ON CLICK, recalculate rating ((thumbs up / total votes) * 5) -->
                            <?php if(Session::get('color_scheme') == 'light'): ?>
                                <?php if((isset($location_interest->vote)) and ($location_interest->vote != 'neutral')): ?>
                                    <!-- TODO: ON HOVER, SHOW LIGHT -->
                                    <img src="/images/ratings/rating_neutral.png" width="30" height="30" style="margin-bottom: 5px;"><br><span style="color: #d8d8d8;">It's OK</span>
                                <?php else: ?>
                                    <img src="/images/ratings/rating_neutral_light.png" width="30" height="30" style="margin-bottom: 5px;"><br>It's OK
                                <?php endif; ?>
                            <?php else: ?>
                                <?php if((isset($location_interest->vote)) and ($location_interest->vote != 'neutral')): ?>
                                    <!-- TODO: ON HOVER, SHOW DARK -->
                                    <img src="/images/ratings/rating_neutral_light.png" width="30" height="30" style="margin-bottom: 5px;"><br><span style="color: #1a1a1a;">It's OK</span>
                                <?php else: ?>
                                    <img src="/images/ratings/rating_neutral.png" width="30" height="30" style="margin-bottom: 5px;"><br>It's OK
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <div style="width: 60px; font-size: 0.7em;">
                            <!-- TODO: ON CLICK, add one to thumbs up -->
                            <!-- TODO: ON CLICK, recalculate rating ((thumbs up / total votes) * 5) -->
                            <?php if(Session::get('color_scheme') == 'light'): ?>
                                <?php if((isset($location_interest->vote)) and ($location_interest->vote != 'good')): ?>
                                    <!-- TODO: ON HOVER, SHOW LIGHT -->
                                    <img src="/images/ratings/rating_good.png" width="30" height="30" style="margin-bottom: 5px;"><br><span style="color: #d8d8d8;">Great</span>
                                <?php else: ?>
                                    <img src="/images/ratings/rating_good_light.png" width="30" height="30" style="margin-bottom: 5px;"><br>Great
                                <?php endif; ?>
                            <?php else: ?>
                                <?php if((isset($location_interest->vote)) and ($location_interest->vote != 'good')): ?>
                                    <!-- TODO: ON HOVER, SHOW DARK -->
                                    <img src="/images/ratings/rating_good_light.png" width="30" height="30" style="margin-bottom: 5px;"><br><span style="color: #1a1a1a;">Great</span>
                                <?php else: ?>
                                    <img src="/images/ratings/rating_good.png" width="30" height="30" style="margin-bottom: 5px;"><br>Great
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
                
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    
    <!-- TODO: Only allow activities to be added that the person is a community member of -->
    <?php if((Auth::check()) && (Gate::check('isActive'))): ?>
        <div class="add-an-activity" style="
            display: block; /* block or none */
        ">
            <h2 style="margin-top: 30px;">Is <?php echo e($location->name); ?> missing an activity?</h2>
            <!-- TODO: WHEN CLICKED, New page with list of cards of interests the person is a community member of.  When one is clicked, add to this location; return user to this page -->
            <div class="button">
                <div style="
                    position: absolute;
                    top: 15;
                    left: 15;
                ">
                    <?php if(Session::get('color_scheme') == 'light'): ?>
                        <img src="/images/add_light.png" width="20" height="20">
                    <?php else: ?>
                        <img src="/images/add.png" width="20" height="20">
                    <?php endif; ?>
                </div>
                <div style="margin-left: 30px;">
                    Add an Activity
                </div>
            </div>
        </div>
    <?php endif; ?>
    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.location', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/scott4jesus/Websites/digdoing.com/resources/views/location/things-to-do.blade.php ENDPATH**/ ?>