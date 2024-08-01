@extends('layouts.app')

@section('title', 'What do you dig doing?')

@section('content')
    
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
        background-size: cover;"
    ">
        <div style="
            flex: 0 1 600px;
            width: 100%;
            @if (Session::get('color_scheme') == 'light')
                background: linear-gradient(to bottom, rgba(255,255,255,0) 0%, rgba(255,255,255,0.1) 20%, rgba(255,255,255,0.25) 40%, rgba(255,255,255,0.5) 60%, rgba(255,255,255,0.8) 80%, rgba(255,255,255,1) 100%);
            @else
                background: linear-gradient(to bottom, rgba(0,0,0,0) 0%, rgba(0,0,0,0.1) 20%, rgba(0,0,0,0.25) 40%, rgba(0,0,0,0.5) 60%, rgba(0,0,0,0.8) 80%, rgba(0,0,0,1) 100%);
            @endif
        ">&nbsp;</div>
    </div>
        
    <div style="
        @if (Session::get('color_scheme') == 'light')
            color: #000;
        @else
            color: #fff;
        @endif
        font-weight: 400;">
        
        <h1 style="margin: 0 10px 30px 10px; font-weight: 400;">digDoing Connects People Who Dig Doing Things Together</h1>
        
        <h2 style="font-weight: 400;">Here's What You Can Do:</h2>
        
        <div style="display: flex; flex-flow: column; justify-content: center; align-items: center; width: 100%;">
            
            <div style="display: flex; flex-flow: row; justify-content: space-between; align-items: stretch; width: 100%; max-width: 718px;">
                <div style="flex: 1 1 15%; display: flex; justify-content: flex-end; align-items: center; margin: 10px; text-align: center;">
                    @if (Session::get('color_scheme') == 'light') <img src="/images/home_light_active.png" width="40px;" height="40px;">  @else <img src="/images/home_active.png" width="40px;" height="40px;">  @endif
                </div>
                <div style="flex: 1 1 85%; display: flex; justify-content: flex-start; align-items: center; min-height: 60px; margin: 10px 20px 10px 10px; text-align: left;">
                    Log in and see what's new in your communities.
                </div>
            </div>
            
            <div style="display: flex; flex-flow: row; justify-content: space-between; align-items: stretch; width: 100%; max-width: 718px;">
                <div style="flex: 1 1 15%; display: flex; justify-content: flex-end; align-items: center; margin: 10px; text-align: center;">
                    @if (Session::get('color_scheme') == 'light') <img src="/images/interests_light_active.png" width="40px;" height="40px;">  @else <img src="/images/interests_active.png" width="40px;" height="40px;">  @endif
                </div>
                <div style="flex: 1 1 85%; display: flex; justify-content: flex-start; align-items: center; min-height: 60px; margin: 10px 20px 10px 10px; text-align: left;">
                    Find people who share the same hobbies or interests as you, and even discover a new hobby.  Learn from others in your community who dig doing the same things you do.
                </div>
            </div>
            
            <div style="display: flex; flex-flow: row; justify-content: space-between; align-items: stretch; width: 100%; max-width: 718px;">
                <div style="flex: 1 1 15%; display: flex; justify-content: flex-end; align-items: center; margin: 10px; text-align: center;">
                    @if (Session::get('color_scheme') == 'light') <img src="/images/locations_light_active.png" width="40px;" height="40px;">  @else <img src="/images/locations_active.png" width="40px;" height="40px;">  @endif
                </div>
                <div style="flex: 1 1 85%; display: flex; justify-content: flex-start; align-items: center; min-height: 60px; margin: 10px 20px 10px 10px; text-align: left;">
                    Find places where you can dig doing what you love.  Look near you, or plan an epic trip.  Add activities to your favorite spots and write reviews to help your community. 
                </div>
            </div>
            
            <div style="display: flex; flex-flow: row; justify-content: space-between; align-items: stretch; width: 100%; max-width: 718px;">
                <div style="flex: 1 1 15%; display: flex; justify-content: flex-end; align-items: center; margin: 10px; text-align: center;">
                    @if (Session::get('color_scheme') == 'light') <img src="/images/calendar_light_active.png" width="40px;" height="40px;">  @else <img src="/images/calendar_active.png" width="40px;" height="40px;">  @endif
                </div>
                <div style="flex: 1 1 85%; display: flex; justify-content: flex-start; align-items: center; min-height: 60px; margin: 10px 20px 10px 10px; text-align: left;">
                    Meet up with other people and do what you love together.  Post your favorite events, and grow your community.
                </div>
            </div>
            
            <div style="display: flex; flex-flow: row; justify-content: space-between; align-items: stretch; width: 100%; max-width: 718px;">
                <div style="flex: 1 1 15%; display: flex; justify-content: flex-end; align-items: center; margin: 10px; text-align: center;">
                    @if (Session::get('color_scheme') == 'light') <img src="/images/alerts_light_active.png" width="40px;" height="40px;">  @else <img src="/images/alerts_active.png" width="40px;" height="40px;">  @endif
                </div>
                <div style="flex: 1 1 85%; display: flex; justify-content: flex-start; align-items: center; min-height: 60px; margin: 10px 20px 10px 10px; text-align: left;">
                    Stay up to date on happenings in your community.  See who has responded to your posts, and find out how helpful your posts have been to your community.
                </div>
            </div>
            
            <div style="display: flex; flex-flow: row; justify-content: space-between; align-items: stretch; width: 100%; max-width: 718px;">
                <div style="flex: 1 1 15%; display: flex; justify-content: flex-end; align-items: center; margin: 10px; text-align: center;">
                    @if (Session::get('color_scheme') == 'light') <img src="/images/user_light_active.png" width="40px;" height="40px;">  @else <img src="/images/user_active.png" width="40px;" height="40px;">  @endif
                </div>
                <div style="flex: 1 1 85%; display: flex; justify-content: flex-start; align-items: center; min-height: 60px; margin: 10px 20px 10px 10px; text-align: left;">
                    Create a profile to help your community get to know you better.  Adjust your settings, and customize digDoing to match your personal style.
                </div>
            </div>
            
            <h2>Get Started</h2>
            
            <div style="display: flex; flex-flow: row wrap; justify-content: space-between; align-items: stretch; width: 100%; max-width: 718px;">
                <div style="flex: 1 1 50%; display: flex; justify-content: center; align-items: center; text-align: center;">
                    <a href="/register" class="button button-blue">Register</a>
                </div>
                <div style="flex: 1 1 50%; display: flex; justify-content: center; align-items: center; min-height: 60px; text-align: center;">
                    <a href="/login" class="button">Login</a>
                </div>
            </div>
            
        </div>
    
    </div>
    
@endsection