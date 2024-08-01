@extends('layouts.app')

@section('title', 'API Documentation')

@section('content')
    
    API Documentation
    
    <br><br>
    
    TODO: Determine the best way to handle access tokens.  Use /oauth/token to get an access token.  But the user must record it.  Can we do a one-click request through Socialite?
    
    <br><br>
    
    <h2>Access Tokens for {{ $userName }}</h2>
    <pre style="text-align: left;">@php print_r($accessTokens) @endphp</pre>
    
@endsection