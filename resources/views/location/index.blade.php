@extends('layouts.app')

@section('title')
    Places in {{ $location }} With the Most Things to Do
@endsection

@section('content')
    
    <h1>Where do you dig going?</h1>
    
    <div class="form">
        <div class="search-container">
            <input id="location-search" name="location" type="text" placeholder="Search for a Location">
            <div class="search-spinner">
                @if (Session::get('color_scheme') == 'light')
                    <img src="/images/dig_doing_logo_light.png" width="30px;" height="30px;">
                @else
                    <img src="/images/dig_doing_logo.png" width="30px;" height="30px;">
                @endif
            </div>
        </div>
        <div name="location-suggest" class="input-suggest"></div>
        <div name="location-filter" style="display: flex; width: 100%; margin: 10px 15px 0;">
            <select id="location-filter-country" style="margin: 0 5px;">
                @foreach ($countries as $selectCountry)
                    <option value="{{ $selectCountry->fips }}" @if($selectCountry->fips == $country) selected @endif>{{ $selectCountry->country }}</option>
                @endforeach
            </select>
            <select id="location-filter-state" style="margin: 0 5px;">
                <option value="">Select State...</option>
                @foreach ($states as $selectState)
                    <option value="{{ $selectState->fips }}" data-country="{{ $selectState->country_fips }}" @if($selectState->fips == $state) selected @endif>{{ $selectState->state }}</option>
                @endforeach
            </select>
        </div>
    </div>
    
    <h2>Places in {{ $location }} With the Most Things to Do</h2>

    <div class="loading-spinner">
        @if (Session::get('color_scheme') == 'light')
            <img src="/images/dig_doing_logo_light.png" width="60px;" height="60px;">
        @else
            <img src="/images/dig_doing_logo.png" width="60px;" height="60px;">
        @endif
    </div>
    
    <div class="card-container">
    </div>
    
    <script>
        var loadingSpinner      = $('.loading-spinner');
        var searchSpinner       = $('.search-spinner');
        var country             = '{{ $country }}';
        var state               = '{{ $state }}';
        var searchLocation      = $('input[name="location"]');
        var suggestLocation     = $('div[name="location-suggest"]');
        var searchAjaxWorking   = false;

        // Get list of locations and populate cards
        var getLocationsURL     = '';
        if (country != '') {
            getLocationsURL     = '/' + country;
        }
        if (state != '') {
            getLocationsURL     += '/' + state;
        }
        $.ajax({
            type:       'get',
            dataType:   'json',
            url:        location.protocol + '//api.' + document.domain + '/v1/locations/list' + getLocationsURL
        }).done(function(data) {
            // Populate Cards
            $.each(data, function(key, location) {
                // Fix Slug Invalid Characters
                location.slug   = location.slug.replace(/[^\w\s]/gi, '');

                // Pretify Alternate Names
                location.alternatenames     = location.alternatenames.replace(/,/g, ', ');

                // Outer Card Div
                var locationCard    = "<div id=\"card-" + location.slug + "\" class=\"card card-small link card-location\" onclick=\"location.href='/location/" + location.country + "/" + location.state + "/" + location.slug + "';\" style=\"display: none; position: relative; background-color: #" + location.color + "; ";
                if ((typeof(location.image) != "undefined") && (location.image)) {
                    locationCard   += "background-image: url('" + location.image + "'); ";
                }
                locationCard    += "\" data-search=\"" + location.slug + " " + location.slug_search + "\">";

                // Overlay
                locationCard    += "<div style=\"position: absolute; top: 0; height: 170px; width: 100%; ";
                @if (Session::get('color_scheme') == 'light')
                    locationCard    += "background: linear-gradient(to top, rgba(255,255,255,0) 0%, rgba(255,255,255,0.1) 20%, rgba(255,255,255,0.25) 40%, rgba(255,255,255,0.5) 60%, rgba(255,255,255,0.8) 80%, rgba(255,255,255,1) 100%); ";
                @else
                    locationCard    += "background: linear-gradient(to top, rgba(0,0,0,0) 0%, rgba(0,0,0,0.1) 20%, rgba(0,0,0,0.25) 40%, rgba(0,0,0,0.5) 60%, rgba(0,0,0,0.8) 80%, rgba(0,0,0,1) 100%); ";
                @endif
                    locationCard    += "\">&nbsp;</div>";

                // Card Name
                locationCard    += "<div class=\"card-name\" style=\"z-index: 10;\">" + location.name + "</div>";

                // Card Tag
                if (location.alternatenames != '') {
                    locationCard    += "<div class=\"card-tag\" style=\"z-index: 10;\">(" + location.alternatenames + ")</div>";
                }

                // Closing Outer Card Div
                locationCard   += "</div>";

                $('.card-container').append(locationCard);
                $('#card-' + location.slug).fadeIn(750);
            });

            // Clear the Loading Spinner
            loadingSpinner.css('animation', 'fadeOut 1s 1');
            setTimeout(function () {
                loadingSpinner.hide();
            }, 750);
        });

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

            $('div.card-location').hide();

            window.location.href = "/location/" + $(this).data('country') + "/" + $(this).data('state') + "/" + $(this).data('slug');
        });
        
        $('select').on('change', function() {
            if ($(this).val()) {
                loadingSpinner.show();
                loadingSpinner.css('animation', 'pulse 750ms infinite');

                $('div.card-location').hide();

                window.location.href = "/location/" + $(this).find(':selected').data('country') + "/" + $(this).val();
            }
        });

        $('.card-container').on('click tap touch', 'div.card-location', function() {
            loadingSpinner.show();
            loadingSpinner.css('animation', 'pulse 750ms infinite');

            $('div.card-location').hide();
        });

    </script>
    
@endsection