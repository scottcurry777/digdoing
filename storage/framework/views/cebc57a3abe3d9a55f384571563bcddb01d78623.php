<?php $__env->startSection('title'); ?>
    Most Popular Things to Do
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    
    <h1>What do you dig doing?</h1>
    
    <div class="form">
        <input name="interest" type="text" placeholder="Filter">
    </div>

    <h2>Most Popular Things to Do</h2>

    <div class="loading-spinner">
        <?php if(Session::get('color_scheme') == 'light'): ?>
            <img src="/images/dig_doing_logo_light.png" width="60px;" height="60px;">
        <?php else: ?>
            <img src="/images/dig_doing_logo.png" width="60px;" height="60px;">
        <?php endif; ?>
    </div>

    <div class="card-container">
    </div>
    
    <script>
        var loadingSpinner  = $('.loading-spinner');
        var searchInterest  = $('input[name=interest]');
        
        searchInterest.on('change keyup paste', function() {
            // Remove spaces because we are searching slugs
            searchValue = searchInterest.val().replace(/\s/g, '').toLowerCase();
            
            if (searchValue) {
                $('div.card-interest[data-search*=' + searchValue + ']').show();
                $('div.card-interest:not([data-search*=' + searchValue + '])').hide();
            } else {
                $('div.card-interest').show();
            }
        });

        // Get list of interests and populate cards
        $.ajax({
            type:       'get',
            dataType:   'json',
            url:        location.protocol + '//api.' + document.domain + '/v1/interests/list'
        }).done(function(data) {
            // Populate Cards
            $.each(data, function(key, interest) {
                // Outer Card Div
                var interestCard   = "<div id=\"card-" + interest.slug + "\" class=\"card card-small link card-interest\" onclick=\"location.href='/" + interest.slug + "';\" style=\"display: none; position: relative; background-color: #" + interest.color + "; ";
                if ((typeof(interest.image) != "undefined") && (interest.image)) {
                    interestCard   += "background-image: url('" + interest.image + "'); ";
                }
                interestCard    += "\" data-search=\"" + interest.slug + " " + interest.slug_search + "\">";

                // Overlay
                interestCard    += "<div style=\"position: absolute; top: 0; height: 170px; width: 100%; ";
                <?php if(Session::get('color_scheme') == 'light'): ?>
                    interestCard    += "background: linear-gradient(to top, rgba(255,255,255,0) 0%, rgba(255,255,255,0.1) 20%, rgba(255,255,255,0.25) 40%, rgba(255,255,255,0.5) 60%, rgba(255,255,255,0.8) 80%, rgba(255,255,255,1) 100%); ";
                <?php else: ?>
                    interestCard    += "background: linear-gradient(to top, rgba(0,0,0,0) 0%, rgba(0,0,0,0.1) 20%, rgba(0,0,0,0.25) 40%, rgba(0,0,0,0.5) 60%, rgba(0,0,0,0.8) 80%, rgba(0,0,0,1) 100%); ";
                <?php endif; ?>
                interestCard    += "\">&nbsp;</div>";

                // Card Name
                interestCard    += "<div class=\"card-name\" style=\"z-index: 10;\">" + interest.name + "</div>";

                // Card Tag
                interestCard    += "<div class=\"card-tag\" style=\"z-index: 10;\">" + interest.tag + "</div>";

                // Closing Outer Card Div
                interestCard   += "</div>";

                $('.card-container').append(interestCard);
                $('#card-' + interest.slug).fadeIn(750);
            });

            // Clear the Loading Spinner
            loadingSpinner.css('animation', 'fadeOut 1s 1');
            setTimeout(function () {
                loadingSpinner.hide();
            }, 750);
        });

        $('.card-container').on('click tap touch', 'div.card-interest', function() {
            loadingSpinner.show();
            loadingSpinner.css('animation', 'pulse 750ms infinite');
            $('div.card-interest').hide();
        });
    </script>
    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/scott4jesus/Websites/digdoing.com/resources/views/interest/index.blade.php ENDPATH**/ ?>