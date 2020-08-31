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

			<p>Bei Rückfragen wenden Sie sich bitte direkt an Herrn Hoffmann (Di., Do., Fr. zwischen 8.00 und 9.00 Uhr, Tel. 0541/318741 oder <a href="mailto:matthias.hoffmann@urs-os.de">matthias.hoffmann@urs-os.de</a>). Bitte berücksichtigen Sie, dass unser Sekretariat keine Rückfragen beantworten kann!</p>

		</div>
	    
	    <div class="col-md-6">


	    </div>

	</div>

@endsection