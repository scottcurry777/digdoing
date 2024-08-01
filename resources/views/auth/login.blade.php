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
        margin-bottom: -430px;
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

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group row">
            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

            <div class="col-md-6">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

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
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6 offset-md-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Login') }}
                </button>

                @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif
            </div>
        </div>
    </form>

    <!--
    <h2 style="margin: 0 0 30px 0; font-weight: 400;">How would you like to login?</h2>

    <div style="margin-bottom: 30px;">
        <a href="{{url('/login/social/facebook')}}" class="button button-blue" style="margin: 10px;">Login with Facebook</a>
    </div>
    <div style="margin-bottom: 30px;">
        <a href="{{url('/login/social/google')}}" class="button" style="margin: 10px;">Login with Google</a>
    </div>
    -->

@endsection