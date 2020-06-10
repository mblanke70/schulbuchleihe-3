@extends('layouts.home')

@section('title', 'Anmeldung zur Buchausleihe im Schuljahr 2020/21')

@section('heading')
    <h4>Bestellbestätigung</h4>
    <h4>{{ Auth::user()->vorname }} {{ Auth::user()->nachname }} ({{ Auth::user()->klasse }})</h4> 
@endsection

@section('content')
	
	@if ($errors->any())
	    <div class="alert alert-danger">
	        {{ $errors->first() }}
	    </div>
	@endif
    
    <h5>Ihre Bestellung ist aufgenommen worden.</h5>

    <p>Eine Bestellbestätigung ist per Email an die Adresse</p>

    <h5>{{ Auth::user()->familie->email }}</h5>

    <p>versendet worden.</p>
        
    <p>Die Seite ist über das IServ-Menü permanent erreichbar. Schüler können hier nicht nur am Leihverfahren teilnehmen sondern später auch jederzeit einsehen, welche Bücher sie aktuell ausgeliehen haben.</p>
            
@endsection