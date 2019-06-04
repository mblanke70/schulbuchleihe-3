@extends('layouts.home')

@section('title', 'Anmeldung zur Buchausleihe im Schuljahr 2019/20')

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

    <p>Sie werden mit dem nächsten Klick auf die Startseite des Verfahrens weitergeleitet, auf der jetzt die Listen der gewählten Leih- bzw. Kaufbücher angezeigt werden. Es besteht dort auch die Möglichkeit, noch einmal neu zu wählen.</p>
        

    <h4>Über diese Webseite</h4>
       
    <P>Diese Webseite ist im Schuljahr 2017/18 im Rahmen des Seminarfachs Informatik im Jahrgang 12 neu konzipiert und (in Teilen) entwickelt worden. Neben dem Leihverfahren, wird auch die Ausleihe und Rückgabe der Bücher sowie die Bestandspflege der schuleigenen Bücher über die Webseite abgewickelt.</P>
    
    <p>Die Seite ist über das IServ-Menü permanent erreichbar. Schüler können hier nicht nur am Leihverfahren teilnehmen sondern später auch jederzeit einsehen, welche Bücher sie aktuell ausgeliehen haben.</p>
            
@endsection