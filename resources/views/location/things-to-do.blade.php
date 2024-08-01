@extends('layouts.location')

@section('title')
Things to Do {{ $location->adverb }} {{ $location->name }}
@endsection

@section('main-content')



    <!-- <pre style="text-align: left;">@php print_r($location_interests) @endphp</pre> -->
    
    
    <div class="card-container">
        @foreach ($location_interests as $location_interest)
            <div class="card card-small link card-interest" onclick="location.href='/{{ $location_interest->slug }}/discussion/{{ $location->country_fips }}/{{ $location->state_fips }}/{{ $location->slug }}/';" style="
                position: relative;
                @if($location_interest->image) background-image: url('{{ $location_interest->image }}'); @else background: #@php echo substr(dechex(crc32($location_interest->slug)), 0, 6); @endphp; @endif
                
                @if ($location_interest->userJoined)
                    margin-bottom: 110px;
                @endif
            ">
                <div style="
                    position: absolute;
                    top: 0;
                    height: 170px;
                    width: 100%;
                    @if (Session::get('color_scheme') == 'light')
                        background: linear-gradient(to top, rgba(255,255,255,0) 0%, rgba(255,255,255,0.1) 20%, rgba(255,255,255,0.25) 40%, rgba(255,255,255,0.5) 60%, rgba(255,255,255,0.8) 80%, rgba(255,255,255,1) 100%);
                    @else
                        background: linear-gradient(to top, rgba(0,0,0,0) 0%, rgba(0,0,0,0.1) 20%, rgba(0,0,0,0.25) 40%, rgba(0,0,0,0.5) 60%, rgba(0,0,0,0.8) 80%, rgba(0,0,0,1) 100%);
                    @endif
                ">&nbsp;</div>
                <div class="card-name" style="z-index: 10;">
                    {{ $location_interest->name }}
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
                    @if (Session::get('color_scheme') == 'light')
                        background: rgba(255,255,255,0.9);
                    @else
                        background: rgba(0,0,0,0.9);
                    @endif
                    border-radius: 5px 0px 0px 0px;
                ">
                    @if (!$location_interest->rating)
                        <span style="font-size: 0.7em;">Not Yet Rated</span>
                    @else
                        <div style="float: left;">
                            <span style="font-size: 0.7em;">{{ $location_interest->rating }} / 5.00</span><br>
                            @if ($location_interest->rating < 1)
                                Not Recommended
                            @elseif ($location_interest->rating < 2)
                                Not Great
                            @elseif ($location_interest->rating < 3)
                                It's OK
                            @elseif ($location_interest->rating < 4)
                                Recommended
                            @else
                                Highly Recommended
                            @endif
                        </div>
                        <div style="
                            float: right;
                            padding: 3px 0 3px 6px;
                        ">
                            @if (Session::get('color_scheme') == 'light')
                                @if ($location_interest->rating < 1)
                                    <img src="/images/ratings/rating_bad_light.png" width="30" height="30">
                                @elseif ($location_interest->rating < 2)
                                    <img src="/images/ratings/rating_bad_light.png" width="30" height="30">
                                @elseif ($location_interest->rating < 3)
                                    <img src="/images/ratings/rating_neutral_light.png" width="30" height="30">
                                @elseif ($location_interest->rating < 4)
                                    <img src="/images/ratings/rating_good_light.png" width="30" height="30">
                                @else
                                    <img src="/images/ratings/rating_good_light.png" width="30" height="30">
                                @endif
                            @else
                                @if ($location_interest->rating < 1)
                                    <img src="/images/ratings/rating_bad.png" width="30" height="30">
                                @elseif ($location_interest->rating < 2)
                                    <img src="/images/ratings/rating_bad.png" width="30" height="30">
                                @elseif ($location_interest->rating < 3)
                                    <img src="/images/ratings/rating_neutral.png" width="30" height="30">
                                @elseif ($location_interest->rating < 4)
                                    <img src="/images/ratings/rating_good.png" width="30" height="30">
                                @else
                                    <img src="/images/ratings/rating_good.png" width="30" height="30">
                                @endif
                            @endif
                        </div>
                    @endif
                </div>
                
                @if ($location_interest->userJoined)
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
                            How is {{ $location_interest->name }} at {{ $location->name }}? @if (isset($location_interest->vote)) <br><span style="font-weight: 700;">You Rated It</span> @endif
                        </div>
                        <div style="width: 60px; font-size: 0.7em;">
                            <!-- TODO: ON CLICK, add one to thumbs down -->
                            <!-- TODO: ON CLICK, recalculate rating ((thumbs up / total votes) * 5) -->
                            @if (Session::get('color_scheme') == 'light')
                                @if ((isset($location_interest->vote)) and ($location_interest->vote != 'bad'))
                                    <!-- TODO: ON HOVER, SHOW LIGHT -->
                                    <img src="/images/ratings/rating_bad.png" width="30" height="30" style="margin-bottom: 5px;"><br><span style="color: #d8d8d8;">Terrible</span>
                                @else
                                    <img src="/images/ratings/rating_bad_light.png" width="30" height="30" style="margin-bottom: 5px;"><br>Terrible
                                @endif
                            @else
                                @if ((isset($location_interest->vote)) and ($location_interest->vote != 'bad'))
                                    <!-- TODO: ON HOVER, SHOW DARK -->
                                    <img src="/images/ratings/rating_bad_light.png" width="30" height="30" style="margin-bottom: 5px;"><br><span style="color: #1a1a1a;">Terrible</span>
                                @else
                                    <img src="/images/ratings/rating_bad.png" width="30" height="30" style="margin-bottom: 5px;"><br>Terrible
                                @endif
                            @endif
                        </div>
                        <div style="width: 60px; font-size: 0.7em;">
                            <!-- TODO: ON CLICK, add one to thumbs up AND one to thumbs down -->
                            <!-- TODO: ON CLICK, recalculate rating ((thumbs up / total votes) * 5) -->
                            @if (Session::get('color_scheme') == 'light')
                                @if ((isset($location_interest->vote)) and ($location_interest->vote != 'neutral'))
                                    <!-- TODO: ON HOVER, SHOW LIGHT -->
                                    <img src="/images/ratings/rating_neutral.png" width="30" height="30" style="margin-bottom: 5px;"><br><span style="color: #d8d8d8;">It's OK</span>
                                @else
                                    <img src="/images/ratings/rating_neutral_light.png" width="30" height="30" style="margin-bottom: 5px;"><br>It's OK
                                @endif
                            @else
                                @if ((isset($location_interest->vote)) and ($location_interest->vote != 'neutral'))
                                    <!-- TODO: ON HOVER, SHOW DARK -->
                                    <img src="/images/ratings/rating_neutral_light.png" width="30" height="30" style="margin-bottom: 5px;"><br><span style="color: #1a1a1a;">It's OK</span>
                                @else
                                    <img src="/images/ratings/rating_neutral.png" width="30" height="30" style="margin-bottom: 5px;"><br>It's OK
                                @endif
                            @endif
                        </div>
                        <div style="width: 60px; font-size: 0.7em;">
                            <!-- TODO: ON CLICK, add one to thumbs up -->
                            <!-- TODO: ON CLICK, recalculate rating ((thumbs up / total votes) * 5) -->
                            @if (Session::get('color_scheme') == 'light')
                                @if ((isset($location_interest->vote)) and ($location_interest->vote != 'good'))
                                    <!-- TODO: ON HOVER, SHOW LIGHT -->
                                    <img src="/images/ratings/rating_good.png" width="30" height="30" style="margin-bottom: 5px;"><br><span style="color: #d8d8d8;">Great</span>
                                @else
                                    <img src="/images/ratings/rating_good_light.png" width="30" height="30" style="margin-bottom: 5px;"><br>Great
                                @endif
                            @else
                                @if ((isset($location_interest->vote)) and ($location_interest->vote != 'good'))
                                    <!-- TODO: ON HOVER, SHOW DARK -->
                                    <img src="/images/ratings/rating_good_light.png" width="30" height="30" style="margin-bottom: 5px;"><br><span style="color: #1a1a1a;">Great</span>
                                @else
                                    <img src="/images/ratings/rating_good.png" width="30" height="30" style="margin-bottom: 5px;"><br>Great
                                @endif
                            @endif
                        </div>
                    </div>
                @endif
                
            </div>
        @endforeach
    </div>
    
    <!-- TODO: Only allow activities to be added that the person is a community member of -->
    @if ((Auth::check()) && (Gate::check('isActive')))
        <div class="add-an-activity" style="
            display: block; /* block or none */
        ">
            <h2 style="margin-top: 30px;">Is {{ $location->name }} missing an activity?</h2>
            <!-- TODO: WHEN CLICKED, New page with list of cards of interests the person is a community member of.  When one is clicked, add to this location; return user to this page -->
            <div class="button">
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
                    Add an Activity
                </div>
            </div>
        </div>
    @endif
    
@endsection