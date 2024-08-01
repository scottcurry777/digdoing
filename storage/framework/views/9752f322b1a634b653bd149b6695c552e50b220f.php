


<?php Session::put('color_scheme', 'dark'); ?>



<html>
    <head>
        <title><?php echo $__env->yieldContent('title'); ?> - digDoing</title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="google-site-verification" content="YFaKKqD4OO2fLr8vkC_ZtE5FmNRYL0BkzLvzIWVo4CM" />
        
        <link rel="icon" type="image/png" href="/images/favicon.png">
        
        <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
        <link href="/css/app.css" rel="stylesheet">
        
        <script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
        
    </head>
    <body <?php if(Session::get('color_scheme') == 'light'): ?> class="light" <?php endif; ?>>
        <header>
            <div id="logo">
                <?php if(Session::get('color_scheme') == 'light'): ?>
                    <a href="/"><img src="/images/dig_doing_logo_light.png" width="30px;" height="30px;"></a>
                <?php else: ?>
                    <a href="/"><img src="/images/dig_doing_logo.png" width="30px;" height="30px;"></a>
                <?php endif; ?>
            </div>
            
            <div id="search">
                <input name="search" type="text" placeholder="Search" style="margin: 0;">
            </div>
            
            <div id="user">
                <?php $__env->startSection('user-actions'); ?>
                    <?php if(Session::get('color_scheme') == 'light'): ?>
                        <a href="/user"><?php if((isset(request()->segments()[0])) && (request()->segments()[0] == 'user')): ?> <img src="/images/user_light_active.png" width="30px;" height="30px;"> <?php else: ?> <img src="/images/user_light.png" width="30px;" height="30px;"> <?php endif; ?></a>
                    <?php else: ?>
                        <a href="/user"><?php if((isset(request()->segments()[0])) && (request()->segments()[0] == 'user')): ?> <img src="/images/user_active.png" width="30px;" height="30px;"> <?php else: ?> <img src="/images/user.png" width="30px;" height="30px;"> <?php endif; ?></a>
                    <?php endif; ?>
                <?php echo $__env->yieldSection(); ?>
            </div>
        </header>
        
        <div id="main">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
        
        <nav>
            <div class="nav-container">
                <?php if(Session::get('color_scheme') == 'light'): ?>
                    <div class="nav-item">
                        <a href="/"><?php if(!count(request()->segments())): ?> <img src="/images/home_light_active.png" width="30px;" height="30px;"> <?php else: ?> <img src="/images/home_light.png" width="30px;" height="30px;"> <?php endif; ?></a>
                    </div>
                    <div class="nav-item">
                        <a href="/interests"><?php if(((isset(request()->segments()[0])) && (request()->segments()[0] == 'interests')) || ((isset($isInterest)) && ($isInterest))): ?> <img src="/images/interests_light_active.png" width="30px;" height="30px;"> <?php else: ?> <img src="/images/interests_light.png" width="30px;" height="30px;"> <?php endif; ?></a>
                    </div>
                    <div class="nav-item">
                        <a href="/location"><?php if((isset(request()->segments()[0])) && (request()->segments()[0] == 'location')): ?> <img src="/images/locations_light_active.png" width="30px;" height="30px;"> <?php else: ?> <img src="/images/locations_light.png" width="30px;" height="30px;"> <?php endif; ?></a>
                    </div>
                    <div class="nav-item">
                        <a href="/calendar"><?php if((isset(request()->segments()[0])) && (request()->segments()[0] == 'calendar')): ?> <img src="/images/calendar_light_active.png" width="30px;" height="30px;"> <?php else: ?> <img src="/images/calendar_light.png" width="30px;" height="30px;"> <?php endif; ?></a>
                    </div>
                    <div class="nav-item">
                        <a href="/alerts"><?php if((isset(request()->segments()[0])) && (request()->segments()[0] == 'alerts')): ?> <img src="/images/alerts_light_active.png" width="30px;" height="30px;"> <?php else: ?> <img src="/images/alerts_light.png" width="30px;" height="30px;"> <?php endif; ?></a>
                    </div>
                <?php else: ?>
                    <div class="nav-item">
                        <a href="/"><?php if(!count(request()->segments())): ?> <img src="/images/home_active.png" width="30px;" height="30px;"> <?php else: ?> <img src="/images/home.png" width="30px;" height="30px;"> <?php endif; ?></a>
                    </div>
                    <div class="nav-item">
                        <a href="/interests"><?php if(((isset(request()->segments()[0])) && (request()->segments()[0] == 'interests')) || ((isset($isInterest)) && ($isInterest))): ?> <img src="/images/interests_active.png" width="30px;" height="30px;"> <?php else: ?> <img src="/images/interests.png" width="30px;" height="30px;"> <?php endif; ?></a>
                    </div>
                    <div class="nav-item">
                        <a href="/location"><?php if((isset(request()->segments()[0])) && (request()->segments()[0] == 'location')): ?> <img src="/images/locations_active.png" width="30px;" height="30px;"> <?php else: ?> <img src="/images/locations.png" width="30px;" height="30px;"> <?php endif; ?></a>
                    </div>
                    <div class="nav-item">
                        <a href="/calendar"><?php if((isset(request()->segments()[0])) && (request()->segments()[0] == 'calendar')): ?> <img src="/images/calendar_active.png" width="30px;" height="30px;"> <?php else: ?> <img src="/images/calendar.png" width="30px;" height="30px;"> <?php endif; ?></a>
                    </div>
                    <div class="nav-item">
                        <a href="/alerts"><?php if((isset(request()->segments()[0])) && (request()->segments()[0] == 'alerts')): ?> <img src="/images/alerts_active.png" width="30px;" height="30px;"> <?php else: ?> <img src="/images/alerts.png" width="30px;" height="30px;"> <?php endif; ?></a>
                    </div>
                <?php endif; ?>
            </div>
        </nav>
            
        <footer>
            <div id="footer">
                <p style="margin: 0; font-size: 0.7em;">
                    <span style="font-size: 0.9em;">Created by Scott Curry</span><br>
                    Copyright 2020 - <?php echo e(now()->year); ?> &copy; Scott Curry.&nbsp;&nbsp;All Rights Reserved.
                </p>
            </div>
        </footer>

        <script>
            $('.nav-item').on('click tap touch', function() {
                loadingSpinner.show();
                loadingSpinner.css('animation', 'pulse 750ms infinite');
            });
        </script>
    </body>
</html><?php /**PATH /home/scott4jesus/Websites/digdoing.com/resources/views/layouts/app.blade.php ENDPATH**/ ?>