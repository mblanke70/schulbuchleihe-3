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

	<div class="row">
	    
	    <div class="col-md-6">

	    	<p><strong>Liebe Eltern, liebe Schülerinnen und Schüler!</strong></p>

			<p>Die Anmeldung für die Schulbuchausleihe hat geschlossen.</p>

			<p>Die Bücherlisten für das Schuljahr 2019/20 können <a href="{{ url('user/buecherlisten') }}">hier</a> eingesehen werden.</p>

		</div>
	    
	    <div class="col-md-6">

	    </div>

	</div>

@endsection