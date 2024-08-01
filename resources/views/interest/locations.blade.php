@extends('layouts.interest')

@section('title')
Places to {{ ucfirst($interest->adverb) }} {{ $interest->name }} @if($locationName) {{ $locationAdverb }} {{ $locationName }} @endif
@endsection

@section('main-content')

    <div class="loading-spinner">
        @if (Session::get('color_scheme') == 'light')
            <img src="/images/dig_doing_logo_light.png" width="60px;" height="60px;">
        @else
            <img src="/images/dig_doing_logo.png" width="60px;" height="60px;">
        @endif
    </div>

    <div class="card-container">
    </div>

    @if (($userJoined) && (Gate::check('isActive')))
        <div class="add-an-activity" style="
            display: block; /* block or none */
        ">
            <h2 style="margin-top: 30px;">Is there another place to {{ $interest->adverb }} {{ $interest->name }}@if($locationName) {{ $locationAdverb }} {{ $locationName }} @endif?</h2>
            <!-- TODO: WHEN CLICKED, New page with list of cards of locations.  When one is clicked, add to this interest; return user to this page -->
            <div style="
                width: 150px;
                padding: 10px;
                margin: 0 auto 30px;
                @if (Session::get('color_scheme') == 'light')
                    border: 2px #1a1a1a solid;
                @else
                    border: 2px #a1a1a1 solid;
                @endif
                border-radius: 5px;
                line-height: 30px;
                position: relative;
            ">
                <div style="
                    position: absolute;
                    top: 15;
                    left: 15;
                ">
                    @if (Session::get('color_scheme') == 'light')
                        <img src="/images/add_light.png" width="20" height="20">
                    @else
                        <img src="/images/add.png" width="20" height="20">
                    @endif
                </div>
                <div style="margin-left: 30px;">
                    Add a Location
                </div>
            </div>
        </div>
    @endif

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
        var interestID          = '{{ $interest->id }}';
        var country             = '{{ $country }}';
        var state               = '{{ $state }}';
        var locationParentID    = '{{ $locationParentID }}';
        var searchLocation      = $('input[name="location"]');
        var suggestLocation     = $('div[name="location-suggest"]');
        var searchAjaxWorking   = false;

        // Get list of locations and populate cards
        $.ajax({
            type:       'get',
            dataType:   'json',
            url:        location.protocol + '//api.' + document.domain + '/v1/interests/interestlocations' + '?interestID=' + interestID + '&country=' + country + '&state=' + state + '&locationParentID=' + locationParentID
        }).done(function(data) {
            // Populate Cards
            if (!$.trim(data)){
                var noLocations = "We don't know of any places to {{ $interest->adverb }} {{ $interest->name }}@if($locationName) {{ ' ' . $locationAdverb }} {{ $locationName . '.'}} @else{{ '.' }} @endif<br>";

                @if (($userJoined) && (Gate::check('isActive')))
                    noLocations += "If you know of a place, please add a location below."
                @else
                    noLocations += "If you know of a place, please join this community and add a location."
                @endif

                $('.card-container').append(noLocations);
            } else {
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
                    @if (($userJoined) && (Gate::check('isActive')))
                        locationCard    += "margin-bottom: 110px; ";
                    @endif
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
                    locationCard    += "<div class=\"card-tag\" style=\"z-index: 10; position: absolute; bottom: 0; right: 0; height: initial; padding: 3px 6px; font-size: 1em; text-align: right; ";
                    @if (Session::get('color_scheme') == 'light')
                        locationCard    += "background: rgba(255,255,255,0.9); "
                    @else
                        locationCard    += "background: rgba(0,0,0,0.9); ";
                    @endif
                    locationCard    += "border-radius: 5px 0px 0px 0px;\">";
                    if(typeof(location.rating) != null) {
                        locationCard    += "<span style=\"font-size: 0.7em;\">Not Yet Rated</span>";
                    } else {
                        locationCard    += "<div style=\"float: left;\">";
                        locationCard    += "<span style=\"font-size: 0.7em;\">" + location.rating + " / 5.00</span><br>";
                        if (location.rating < 1) {
                            locationCard    += "Not Recommended";
                        } else if (location.rating < 2) {
                            locationCard    += "Not Great";
                        } else if (location.rating < 3) {
                            locationCard    += "It's OK";
                        } else if (location.rating < 4) {
                            locationCard    += "Recommended";
                        } else {
                            locationCard    += "Highly Recommended";
                        }
                        locationCard    += "</div>";
                        locationCard    += "<div style=\"float: right; padding: 3px 0 3px 6px;\">";
                        @if (Session::get('color_scheme') == 'light')
                            if (location.rating < 1) {
                                locationCard    += "<img src=\"/images/ratings/rating_bad_light.png\" width=\"30\" height=\"30\">";
                            } else if (location.rating < 2) {
                                locationCard    += "<img src=\"/images/ratings/rating_bad_light.png\" width=\"30\" height=\"30\">";
                            } else if (location.rating < 3) {
                                locationCard    += "<img src=\"/images/ratings/rating_neutral_light.png\" width=\"30\" height=\"30\">";
                            } else if (location.rating < 4) {
                                locationCard    += "<img src=\"/images/ratings/rating_good_light.png\" width=\"30\" height=\"30\">";
                            } else {
                                locationCard    += "<img src=\"/images/ratings/rating_good_light.png\" width=\"30\" height=\"30\">";
                            }
                        @else
                            if (location.rating < 1) {
                                locationCard    += "<img src=\"/images/ratings/rating_bad.png\" width=\"30\" height=\"30\">";
                            } else if (location.rating < 2) {
                                locationCard    += "<img src=\"/images/ratings/rating_bad.png\" width=\"30\" height=\"30\">";
                            } else if (location.rating < 3) {
                                locationCard    += "<img src=\"/images/ratings/rating_neutral.png\" width=\"30\" height=\"30\">";
                            } else if (location.rating < 4) {
                                locationCard    += "<img src=\"/images/ratings/rating_good.png\" width=\"30\" height=\"30\">";
                            } else {
                                locationCard    += "<img src=\"/images/ratings/rating_good.png\" width=\"30\" height=\"30\">";
                            }
                        @endif
                        locationCard    += "</div>";
                    }
                    locationCard    += "</div>";

                    // Vote
                    @if (($userJoined) && (Gate::check('isActive')))
                        locationCard    += "<div class=\"ratings\" style=\"position: absolute; width: 100%; height: 30px; bottom: -40px; display: flex; flex-flow: row wrap; justify-content: space-evenly;\">";
                        locationCard    += "<div style=\"flex: 1 1 100%; margin-bottom: 10px; font-size: 0.9em;\">";
                        locationCard    += "How is {{ $interest->name }} at " + location.name + "?";
                        if (location.vote) {
                            locationCard    += "<br><span style=\"font-weight: 700;\">You Rated It</span>";
                        }
                        locationCard    += "</div>";

                        // VOTE: Bad
                        locationCard    += "<div style=\"width: 60px; font-size: 0.7em;\">";
                        // TODO: ON CLICK, add one to thumbs down
                        // TODO: ON CLICK, recalculate rating ((thumbs up / total votes) * 5)
                        @if (Session::get('color_scheme') == 'light')
                            // TODO: ON HOVER, SHOW LIGHT
                            if ((location.vote) && (location.vote != 'bad')) {
                                locationCard    += "<img src=\"/images/ratings/rating_bad.png\" width=\"30\" height=\"30\" style=\"margin-bottom: 5px;\"><br><span style=\"color: #d8d8d8;\">Terrible</span>";
                            } else {
                                locationCard    += "<img src=\"/images/ratings/rating_bad_light.png\" width=\"30\" height=\"30\" style=\"margin-bottom: 5px;\"><br>Terrible";
                            }
                        @else
                            // TODO: ON HOVER, SHOW DARK
                            if ((location.vote) && (location.vote != 'bad')) {
                                locationCard    += "<img src=\"/images/ratings/rating_bad_light.png\" width=\"30\" height=\"30\" style=\"margin-bottom: 5px;\"><br><span style=\"color: #1a1a1a;\">Terrible</span>";
                            } else {
                                locationCard    += "<img src=\"/images/ratings/rating_bad.png\" width=\"30\" height=\"30\" style=\"margin-bottom: 5px;\"><br>Terrible";
                            }
                        @endif
                        locationCard    += "</div>";

                        // VOTE: It's OK
                        locationCard    += "<div style=\"width: 60px; font-size: 0.7em;\">";
                        // TODO: ON CLICK, add one to thumbs up AND one to thumbs down
                        // TODO: ON CLICK, recalculate rating ((thumbs up / total votes) * 5)
                        @if (Session::get('color_scheme') == 'light')
                            // TODO: ON HOVER, SHOW LIGHT
                            if ((location.vote) && (location.vote != 'neutral')) {
                                locationCard    += "<img src=\"/images/ratings/rating_neutral.png\" width=\"30\" height=\"30\" style=\"margin-bottom: 5px;\"><br><span style=\"color: #d8d8d8;\">It's OK</span>";
                            } else {
                                locationCard    += "<img src=\"/images/ratings/rating_neutral_light.png\" width=\"30\" height=\"30\" style=\"margin-bottom: 5px;\"><br>It's OK";
                            }
                        @else
                            // TODO: ON HOVER, SHOW DARK
                            if ((location.vote) && (location.vote != 'neutral')) {
                                locationCard    += "<img src=\"/images/ratings/rating_neutral_light.png\" width=\"30\" height=\"30\" style=\"margin-bottom: 5px;\"><br><span style=\"color: #1a1a1a;\">It's OK</span>";
                            } else {
                                locationCard    += "<img src=\"/images/ratings/rating_neutral.png\" width=\"30\" height=\"30\" style=\"margin-bottom: 5px;\"><br>It's OK";
                            }
                        @endif
                        locationCard    += "</div>";

                        // VOTE: Good
                        locationCard    += "<div style=\"width: 60px; font-size: 0.7em;\">";
                        // TODO: ON CLICK, add one to thumbs up
                        // TODO: ON CLICK, recalculate rating ((thumbs up / total votes) * 5)
                        @if (Session::get('color_scheme') == 'light')
                            // TODO: ON HOVER, SHOW LIGHT
                            if ((location.vote) && (location.vote != 'good')) {
                                locationCard    += "<img src=\"/images/ratings/rating_good.png\" width=\"30\" height=\"30\" style=\"margin-bottom: 5px;\"><br><span style=\"color: #d8d8d8;\">Great</span>";
                            } else {
                                locationCard    += "<img src=\"/images/ratings/rating_good_light.png\" width=\"30\" height=\"30\" style=\"margin-bottom: 5px;\"><br>Great";
                            }
                            @else
                            // TODO: ON HOVER, SHOW DARK
                            if ((location.vote) && (location.vote != 'good')) {
                                locationCard    += "<img src=\"/images/ratings/rating_good_light.png\" width=\"30\" height=\"30\" style=\"margin-bottom: 5px;\"><br><span style=\"color: #1a1a1a;\">Great</span>";
                            } else {
                                locationCard    += "<img src=\"/images/ratings/rating_good.png\" width=\"30\" height=\"30\" style=\"margin-bottom: 5px;\"><br>Great";
                            }
                        @endif
                        locationCard    += "</div>";

                        locationCard    += "</div>";
                    @endif

                    // Closing Outer Card Div
                    locationCard    += "</div>";

                    $('.card-container').append(locationCard);
                    $('#card-' + location.slug).fadeIn(750);
                });
            }

            // Clear the Loading Spinner
            loadingSpinner.css('animation', 'fadeOut 1s 1');
            setTimeout(function () {
                loadingSpinner.hide();
            }, 750);

            $('#different-location-header').css('display', 'flex');
            $('#different-location-form').css('display', 'flex');
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

            window.location.href = "/{{ $interest->slug }}/locations/" + $(this).data('country') + "/" + $(this).data('state') + "/" + $(this).data('slug');
        });

        $('select').on('change', function() {
            if ($(this).val()) {
                loadingSpinner.show();
                loadingSpinner.css('animation', 'pulse 750ms infinite');

                window.location.href = "/{{ $interest->slug }}/locations/" + $(this).find(':selected').data('country') + "/" + $(this).val();
            }
        });

        $('.card-container').on('click tap touch', 'div.card-location', function() {
            loadingSpinner.show();
            loadingSpinner.css('animation', 'pulse 750ms infinite');

            $('div.card-location').hide();
        });
    </script>
    
@endsection