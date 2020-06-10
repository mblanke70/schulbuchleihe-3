@extends('layouts.home')

@section('title', 'Anmeldung zur Buchausleihe im Schuljahr 2020/21')

@section('heading')
    <h4>Bestätigung</h4>
    <h4>{{ Auth::user()->vorname }} {{ Auth::user()->nachname }} ({{ Auth::user()->klasse }})</h4> 
@endsection

@section('content')
	
	@if ($errors->any())
	    <div class="alert alert-danger">
	        {{ $errors->first() }}
	    </div>
	@endif
    
    <h5>Ihre Wahlen sind gespeichert worden.</h5>
        
    <p>Die Seite ist über das IServ-Menü permanent erreichbar. Schüler können hier nicht nur am Leihverfahren teilnehmen sondern später auch jederzeit einsehen, welche Bücher sie aktuell ausgeliehen haben.</p>
            
@endsection