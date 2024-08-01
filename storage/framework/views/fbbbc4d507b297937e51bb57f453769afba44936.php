

<?php $__env->startSection('title', 'What do you dig doing?'); ?>

<?php $__env->startSection('content'); ?>

    <div style="
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        align-items: center;
        flex: 0 1 600px;
        width: 100%;
        margin-bottom: -230px;
        background: url('https://digdoing.com/images/featured/homepage-featured-campfire.png');
        background-position: center;
        background-size: cover;
    ">
        <div style="
            flex: 0 1 600px;
            width: 100%;
            <?php if(Session::get('color_scheme') == 'light'): ?>
                background: linear-gradient(to bottom, rgba(255,255,255,0) 0%, rgba(255,255,255,0.1) 20%, rgba(255,255,255,0.25) 40%, rgba(255,255,255,0.5) 60%, rgba(255,255,255,0.8) 80%, rgba(255,255,255,1) 100%);
            <?php else: ?>
                background: linear-gradient(to bottom, rgba(0,0,0,0) 0%, rgba(0,0,0,0.1) 20%, rgba(0,0,0,0.25) 40%, rgba(0,0,0,0.5) 60%, rgba(0,0,0,0.8) 80%, rgba(0,0,0,1) 100%);
            <?php endif; ?>
        ">&nbsp;</div>
    </div>


    <h2 style="margin-top: 0; font-weight: 400;">2 Easy Steps to Join the Community</h2>

    <h3 style="margin-bottom: 30px;"><span style="font-weight: bold;">Step 1:</span> Enter Your Email and Choose a Password</h3>

    <form method="POST" action="<?php echo e(route('register')); ?>">
        <?php echo csrf_field(); ?>

        <div class="form-group row">
            <label for="name" class="col-md-4 col-form-label text-md-right"><?php echo e(__('Name')); ?></label>

            <div class="col-md-6">
                <input id="name" type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="name" value="<?php echo e(old('name')); ?>" required autocomplete="name" autofocus>

                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>

        <div class="form-group row">
            <label for="email" class="col-md-4 col-form-label text-md-right"><?php echo e(__('E-Mail Address')); ?></label>

            <div class="col-md-6">
                <input id="email" type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email">

                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>

        <div class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right"><?php echo e(__('Password')); ?></label>

            <div class="col-md-6">
                <input id="password" type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" required autocomplete="new-password">

                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>

        <div class="form-group row">
            <label for="password-confirm" class="col-md-4 col-form-label text-md-right"><?php echo e(__('Confirm Password')); ?></label>

            <div class="col-md-6">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    <?php echo e(__('Register')); ?>

                </button>
            </div>
        </div>
    </form>

    <!--
    <h3 style="margin-bottom: 30px;"><span style="font-weight: bold;">Step 1:</span> Register using Facebook or Google</h3>
    
    <div style="margin-bottom: 30px;">
        <a href="<?php echo e(url('/login/social/facebook')); ?>" class="button button-blue" style="margin: 10px;">Register with Facebook</a>
    </div>
    <div style="margin-bottom: 30px;">
        <a href="<?php echo e(url('/login/social/google')); ?>" class="button" style="margin: 10px;">Register with Google</a>
    </div>
    -->

    <h3 style="margin-top: 50px;"><span style="font-weight: bold;">Step 2:</span> Choose Your Interests</h3>
    <h4 style="color: #999999">Waiting for you to complete Step 1...</h4>
    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/scott4jesus/Websites/digdoing.com/resources/views/auth/register.blade.php ENDPATH**/ ?>