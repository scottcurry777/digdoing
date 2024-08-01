@extends('layouts.location')

@section('title')
{{ $location->name }}
@endsection

@section('main-content')

    <div>
        {{ $location->description }}
    </div>
    
    Main Body
    
    
    
    
@endsection