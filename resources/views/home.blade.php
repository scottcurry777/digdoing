@extends('layouts.app')

@section('title', 'What do you dig doing?')

@section('content')
    
    Welcome, Logged In User!
	
	<div id="app"></div>
	<script src="{{ secure_asset('js/app.js') }}"></script>
    
@endsection