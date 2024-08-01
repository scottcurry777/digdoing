<?php $__env->startSection('title'); ?>
<?php echo e($interest->name); ?> Community <?php if($locationName): ?> <?php echo e($locationAdverb); ?> <?php echo e($locationName); ?> <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>

    <div class="loading-spinner">
        <?php if(Session::get('color_scheme') == 'light'): ?>
            <img src="/images/dig_doing_logo_light.png" width="60px;" height="60px;">
        <?php else: ?>
            <img src="/images/dig_doing_logo.png" width="60px;" height="60px;">
        <?php endif; ?>
    </div>
    
    Resources, People who dig this near me, People who dig this around the world

    <div id="different-location-header">
        Select a Different Location
    </div>

    <div id="different-location-form" class="form">
        <div class="search-container">
            <input id="location-search" name="location" type="text" placeholder="Search for a Location">
            <div class="search-spinner">
                <?php if(Session::get('color_scheme') == 'light'): ?>
                    <img src="/images/dig_doing_logo_light.png" width="30px;" height="30px;">
                <?php else: ?>
                    <img src="/images/dig_doing_logo.png" width="30px;" height="30px;">
                <?php endif; ?>
            </div>
        </div>
        <div name="location-suggest" class="input-suggest"></div>
        <div name="location-filter" style="display: flex; width: 100%; margin: 10px 15px 0;">
            <select id="location-filter-country" style="margin: 0 5px;">
                <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $selectCountry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($selectCountry->fips); ?>" <?php if($selectCountry->fips == $country): ?> selected <?php endif; ?>><?php echo e($selectCountry->country); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <select id="location-filter-state" style="margin: 0 5px;">
                <option value="">Select State...</option>
                <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $selectState): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($selectState->fips); ?>" data-country="<?php echo e($selectState->country_fips); ?>" <?php if($selectState->fips == $state): ?> selected <?php endif; ?>><?php echo e($selectState->state); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
    </div>
    
    <script>
        var loadingSpinner      = $('.loading-spinner');
        var searchSpinner       = $('.search-spinner');
        var country             = '<?php echo e($country); ?>';
        var state               = '<?php echo e($state); ?>';
        var searchLocation      = $('input[name="location"]');
        var suggestLocation     = $('div[name="location-suggest"]');
        var searchAjaxWorking   = false;


        // TODO: Get Posts
        /*
        $.ajax({
            type:       'get',
            dataType:   'json',
            url:        location.protocol + '//api.' + document.domain + '/v1/locations/list' + getLocationsURL
        }).done(function(data) {
            // Clear the Loading Spinner
            loadingSpinner.css('animation', 'fadeOut 1s 1');
            setTimeout(function () {
                loadingSpinner.hide();
            }, 750);
        });
        */
        // TODO: Remove this once Get Posts is coded
        loadingSpinner.css('animation', 'fadeOut 1s 1');
        setTimeout(function () {
            loadingSpinner.hide();
        }, 750);

        $('#different-location-header').css('display', 'flex');
        $('#different-location-form').css('display', 'flex');


        function getSearchSuggestions() {
            // Remove spaces because we are searching slugs
            searchValue = searchLocation.val().replace(/\s/g, '').toLowerCase();

            if (searchValue) {
                searchAjaxWorking   = true;

                // Show the Search Spinner
                searchSpinner.show();
                searchSpinner.css('animation', 'pulse 750ms infinite');

                $.ajax({
                    url: '/search?r=json&t=locations&n=5&c=' + country + '&s=' + state + '&q=' + searchValue,
                    dataType: 'json'
                }).done(function(data) {
                    if (data.length > 0) {
                        cardSuggestions = '';
                        $(data).each(function(thisKey, thisSuggestion) {
                            cardSuggestions += '<div class="card suggest-location" style="display: block; height: 20px; align-items: flex-start" data-country="' + thisSuggestion.country_id + '" data-state="' + thisSuggestion.state_id + '" data-slug="' + thisSuggestion.slug + '" data-name="' + thisSuggestion.name + '">' + thisSuggestion.name + ' <span style="margin-left: 5px; font-size: 0.9em; line-height: 1em; color: #aaa; font-style: italic;">(' + thisSuggestion.state + ', ' + thisSuggestion.country + ')</span></div>';
                        });

                        suggestLocation.html(cardSuggestions);
                        if (searchLocation.is(":focus")) {
                            suggestLocation.show();
                        }
                    } else {
                        suggestLocation.hide();
                    }

                    if (searchValue != searchLocation.val().replace(/\s/g, '').toLowerCase()) {
                        getSearchSuggestions();
                    } else {
                        searchAjaxWorking   = false;

                        // Clear the Search Spinner
                        searchSpinner.css('animation', 'fadeOut 1s 1');
                        setTimeout(function () {
                            searchSpinner.hide();
                        }, 750);
                    }
                });
            } else {
                searchAjaxWorking   = false;

                suggestLocation.hide();

                // Clear the Search Spinner
                searchSpinner.css('animation', 'fadeOut 1s 1');
                setTimeout(function () {
                    searchSpinner.hide();
                }, 750);
            }
        }

        searchLocation.on('input keyup paste', function() {
            console.log(searchAjaxWorking);
            if (!searchAjaxWorking) {
                getSearchSuggestions();
            }
        });

        searchLocation.on('focusin', function() {
            suggestLocation.show();
        });

        searchLocation.on('focusout', function() {
            setTimeout(function() {
                suggestLocation.hide();
            }, 100);
        });

        suggestLocation.on('click tap touch', '.suggest-location', function() {
            searchLocation.val($(this).data('name'));
            suggestLocation.hide();

            loadingSpinner.show();
            loadingSpinner.css('animation', 'pulse 750ms infinite');

            window.location.href = "/<?php echo e($interest->slug); ?>/community/" + $(this).data('country') + "/" + $(this).data('state') + "/" + $(this).data('slug');
        });

        $('select').on('change', function() {
            if ($(this).val()) {
                loadingSpinner.show();
                loadingSpinner.css('animation', 'pulse 750ms infinite');

                window.location.href = "/<?php echo e($interest->slug); ?>/community/" + $(this).find(':selected').data('country') + "/" + $(this).val();
            }
        });
    </script>
    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.interest', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/scott4jesus/Websites/digdoing.com/resources/views/interest/community.blade.php ENDPATH**/ ?>