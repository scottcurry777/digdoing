@extends('layouts.interest')

@section('title')
{{ $interest->name }} Together @if($locationName) {{ $locationAdverb }} {{ $locationName }} @endif
@endsection

@section('main-content')

    <div class="loading-spinner">
        @if (Session::get('color_scheme') == 'light')
            <img src="/images/dig_doing_logo_light.png" width="60px;" height="60px;">
        @else
            <img src="/images/dig_doing_logo.png" width="60px;" height="60px;">
        @endif
    </div>
    
    This activity Events.  Dig Doing this Together!

    <div id="different-location-header">
        Select a Different Location
    </div>

    <div id="different-location-form" class="form">
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
    
    <script>
        var loadingSpinner      = $('.loading-spinner');
        var searchSpinner       = $('.search-spinner');
        var country             = '{{ $country }}';
        var state               = '{{ $state }}';
        var searchLocation      = $('input[name="location"]');
        var suggestLocation     = $('div[name="location-suggest"]');
        var searchAjaxWorking   = false;


        // TODO: Get Calendar
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
        // TODO: Remove this once Get Calendar is coded
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

            window.location.href = "/{{ $interest->slug }}/together/" + $(this).data('country') + "/" + $(this).data('state') + "/" + $(this).data('slug');
        });

        $('select').on('change', function() {
            if ($(this).val()) {
                loadingSpinner.show();
                loadingSpinner.css('animation', 'pulse 750ms infinite');

                window.location.href = "/{{ $interest->slug }}/together/" + $(this).find(':selected').data('country') + "/" + $(this).val();
            }
        });
    </script>
    
@endsection