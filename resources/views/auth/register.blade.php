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
        background-size: cover;
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


    <h2 style="margin-top: 0; font-weight: 400;">2 Easy Steps to Join the Community</h2>

    <h3 style="margin-bottom: 30px;"><span style="font-weight: bold;">Step 1:</span> Enter Your Email and Choose a Password</h3>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group row">
            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

            <div class="col-md-6">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                @error('name')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

            <div class="col-md-6">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                @error('email')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

            <div class="col-md-6">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

            <div class="col-md-6">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Register') }}
                </button>
            </div>
        </div>
    </form>

    <!--
    <h3 style="margin-bottom: 30px;"><span style="font-weight: bold;">Step 1:</span> Register using Facebook or Google</h3>
    
    <div style="margin-bottom: 30px;">
        <a href="{{url('/login/social/facebook')}}" class="button button-blue" style="margin: 10px;">Register with Facebook</a>
    </div>
    <div style="margin-bottom: 30px;">
        <a href="{{url('/login/social/google')}}" class="button" style="margin: 10px;">Register with Google</a>
    </div>
    -->

    <h3 style="margin-top: 50px;"><span style="font-weight: bold;">Step 2:</span> Choose Your Interests</h3>
    <h4 style="color: #999999">Waiting for you to complete Step 1...</h4>
    
@endsection