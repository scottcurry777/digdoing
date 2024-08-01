@extends('layouts.app')

@section('title', 'What do you dig doing?')

@section('content')

    <div class="form-group">
        <div class="col-md-8 col-md-offset-4">
          <a href="{{url('/login/social/facebook')}}" class="btn btn-primary">Login with Facebook</a>
        </div>
    </div>
    
    <pre style="text-align: left;">@php print_r(session()->all()); @endphp</pre>
    
@endsection