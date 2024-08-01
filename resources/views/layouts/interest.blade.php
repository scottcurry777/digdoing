@extends('layouts.app')

@section('content')
    
    <div style="
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        align-items: center;
        flex: 0 1 300px;
        width: 100%;
        margin-bottom: -100px;
        background-color: {{ '#' . $interest->color }};
        @if($interest->image) background: url('{{ $interest->image }}'); @endif
        background-position: center;
        background-size: cover;
    ">
        <div style="
            flex: 0 1 250px;
            width: 100%;
            @if (Session::get('color_scheme') == 'light')
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
            @else
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
            @endif
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
                <h1 style="font-size: inherit; font-weight: inherit; margin: 0;">@yield('title')</h1>
            </div>
            <div class="card-tag on-small-center-text" style="text-align: left; text-shadow: none;
            margin: 10px;">
                {{ $interest->tag }}
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
            <div class="on-small-center-items on-small-center-text" style="
                width: 100%;
                text-align: right;
                margin: 0 10px 10px 10px;
                display: flex;
                flex-flow: row wrap;
                justify-content: flex-end;
                align-items: center;
            ">
                <div style="
                    margin: 0 10px 10px 10px;
                    font-size: 0.8em;
                ">
                    {{ $interest->communitySize == 1 ? '1 Person Digs' : $interest->communitySize . ' People Dig' }} This
                </div>
                @if ($userJoined)
                    <div id="leave-community" class="button button-small" style="
                        margin: 0 0 10px 0;
                    ">
                        <!-- TODO: IF JOINED, SHOW "JOINED!", WITH SMALL TEXT "LEAVE COMMUNITY" -->
                        <!-- TODO: WHEN CLICKED, ADD THIS INTEREST TO USER'S USER_INTERESTS; SHOW SPINNER "JOINING COMMUNITY ..."; RELOAD PAGE AFTER AJAX COMPLETE -->
                        <!-- TODO: LOG USER ACTIONS IN TABLE (JOINED COMMUNITY / LEFT COMMUNITY) -->
                        Leave Community
                    </div>
                @else
                    <div id="join-community" class="button button-small button-blue" style="
                        margin: 0 0 10px 0;
                    ">
                        <!-- TODO: IF JOINED, SHOW "JOINED!", WITH SMALL TEXT "LEAVE COMMUNITY" -->
                        <!-- TODO: WHEN CLICKED, ADD THIS INTEREST TO USER'S USER_INTERESTS; SHOW SPINNER "JOINING COMMUNITY ..."; RELOAD PAGE AFTER AJAX COMPLETE -->
                        <!-- TODO: LOG USER ACTIONS IN TABLE (JOINED COMMUNITY / LEFT COMMUNITY) -->
                        Join Community
                    </div>
                @endif
            </div>
            <div class="on-small-center-text" style="
                display: flex;
                flex-direction: row;
                justify-content: flex-start;
                align-items: flex-end;
                text-align: right;
                height: 40px;
                margin-top: -10px;
            ">
                @if (Session::get('color_scheme') == 'light')
                    <div class="nav-item" style="margin: 0 15px;">
                        <a href="/{{ $interest->slug }}/{{ $country ? 'discussion/' . $country . '/' : '' }}{{ $state ?  $state . '/' : '' }}{{ $location ?  $location . '/' : '' }}">@if ((!isset(request()->segments()[1])) || (request()->segments()[1] == 'discussion')) <img src="/images/home_light_active.png" width="20px;" height="20px;"> @else <img src="/images/home_light.png" width="20px;" height="20px;"> @endif</a>
                    </div>
                    <div class="nav-item" style="margin: 0 15px;">
                        <a href="/{{ $interest->slug }}/locations/{{ $country ? $country . '/' : '' }}{{ $state ?  $state . '/' : '' }}{{ $location ?  $location . '/' : '' }}">@if ((isset(request()->segments()[1])) && (request()->segments()[1] == 'locations')) <img src="/images/locations_light_active.png" width="20px;" height="20px;"> @else <img src="/images/locations_light.png" width="20px;" height="20px;"> @endif</a>
                    </div>
                    <div class="nav-item" style="margin: 0 15px;">
                        <a href="/{{ $interest->slug }}/community/{{ $country ? $country . '/' : '' }}{{ $state ?  $state . '/' : '' }}{{ $location ?  $location . '/' : '' }}">@if ((isset(request()->segments()[1])) && (request()->segments()[1] == 'community')) <img src="/images/community_light_active.png" width="20px;" height="20px;"> @else <img src="/images/community_light.png" width="20px;" height="20px;"> @endif</a>
                    </div>
                    <div class="nav-item" style="margin: 0 15px;">
                        <a href="/{{ $interest->slug }}/together/{{ $country ? $country . '/' : '' }}{{ $state ?  $state . '/' : '' }}{{ $location ?  $location . '/' : '' }}">@if ((isset(request()->segments()[1])) && (request()->segments()[1] == 'together')) <img src="/images/calendar_light_active.png" width="20px;" height="20px;"> @else <img src="/images/calendar_light.png" width="20px;" height="20px;"> @endif</a>
                    </div>
                @else
                    <div class="nav-item" style="margin: 0 15px;">
                        <a href="/{{ $interest->slug }}/{{ $country ? 'discussion/' . $country . '/' : '' }}{{ $state ?  $state . '/' : '' }}{{ $location ?  $location . '/' : '' }}">@if ((!isset(request()->segments()[1])) || (request()->segments()[1] == 'discussion')) <img src="/images/home_active.png" width="20px;" height="20px;"> @else <img src="/images/home.png" width="20px;" height="20px;"> @endif</a>
                    </div>
                    <div class="nav-item" style="margin: 0 15px;">
                        <a href="/{{ $interest->slug }}/locations/{{ $country ? $country . '/' : '' }}{{ $state ?  $state . '/' : '' }}{{ $location ?  $location . '/' : '' }}">@if ((isset(request()->segments()[1])) && (request()->segments()[1] == 'locations')) <img src="/images/locations_active.png" width="20px;" height="20px;"> @else <img src="/images/locations.png" width="20px;" height="20px;"> @endif</a>
                    </div>
                    <div class="nav-item" style="margin: 0 15px;">
                        <a href="/{{ $interest->slug }}/community/{{ $country ? $country . '/' : '' }}{{ $state ?  $state . '/' : '' }}{{ $location ?  $location . '/' : '' }}">@if ((isset(request()->segments()[1])) && (request()->segments()[1] == 'community')) <img src="/images/community_active.png" width="20px;" height="20px;"> @else <img src="/images/community.png" width="20px;" height="20px;"> @endif</a>
                    </div>
                    <div class="nav-item" style="margin: 0 15px;">
                        <a href="/{{ $interest->slug }}/together/{{ $country ? $country . '/' : '' }}{{ $state ?  $state . '/' : '' }}{{ $location ?  $location . '/' : '' }}">@if ((isset(request()->segments()[1])) && (request()->segments()[1] == 'together')) <img src="/images/calendar_active.png" width="20px;" height="20px;"> @else <img src="/images/calendar.png" width="20px;" height="20px;"> @endif</a>
                    </div>
                @endif
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
        @yield('main-content')
    </div>

    <script>
        function getAPICredentials() {
            // TODO: Get user's credentials for API
        }

        $('#join-community').on('click tap touch', function() {
            @guest
                // TODO: Log user in
                // TODO: Redirect back here and continue with join community
                // TODO: Perhaps with a ?action=joincommunity or something.
            @endguest
            @auth
                let credentials = getAPICredentials();
                // TODO: Join community
            @endauth
        });
    </script>
    
@endsection