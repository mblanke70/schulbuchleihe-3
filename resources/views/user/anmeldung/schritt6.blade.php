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

    <h5>Erm&auml;&szlig;igung auf den Leihpreis</h5>
        	
	<p>Familien mit drei oder mehr schulpflichtigen Kindern bezahlen für jedes Kind nur 80 Prozent des Entgelts für die Ausleihe. Der Nachweis über jedes schulpflichtige Geschwisterkind, das nicht an der Ursulaschule ist, erfolgt durch Abgabe einer Schulbescheinigung. Diese können zu Beginn des nächsten Schuljahres an an dieser Stelle per Upload übermittelt oder im Sekretariat abgegeben werden.</p>
        
    <p>Wenn Sie jetzt ein weiteres Kind anmelden möchten, müssen Sie sich erst einmal ausloggen</p>

    <form action="{{ url('logout') }}" method="POST" role="form">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
    </form>
            
@endsection