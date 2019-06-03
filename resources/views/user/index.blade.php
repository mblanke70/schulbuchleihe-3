@extends('layouts.home')

@section('title', 'Schulbuchleihe - Ursulaschule Osnabrück')

@section('heading')
    <h4>{{ Auth::user()->vorname }} {{ Auth::user()->nachname }} ({{ Auth::user()->klasse }})</h4> 
@endsection

@section('content')
	
	@if ($errors->any())
	    <div class="alert alert-danger">
	        {{ $errors->first() }}
	    </div>
	@endif

    <h4>USER-Home</h4>

@endsection