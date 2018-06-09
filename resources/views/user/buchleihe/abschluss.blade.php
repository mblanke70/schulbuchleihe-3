@extends('adminlte::page')

@section('title', 'Leihverfahren')

@section('content_header')
    <h1>Leihverfahren: Bestätigung (Schritt 5)</h1>
    <h4>{{ Auth::user()->vorname }} {{ Auth::user()->nachname }} ({{ Auth::user()->klasse }})</h4>    
@stop

@section('content')

<div class="row">

     <div class="col-md-6">

        <div class="box box-solid box-default">    

            <div class="box-header">
                <h3 class="box-title">Bestätigung</h3>
            </div> 
            
            <div class="box-body">  
                <h4>Ihre Wahlen sind gespeichert worden.</h4> 
                <p>Sie werden mit dem nächsten Klick auf die Startseite des Verfahrens weitergeleitet, auf der jetzt die Listen der gewählten Leih- bzw. Kaufbücher angezeigt werden. Es besteht dort auch die Möglichkeit, noch einmal neu zu wählen.</p>
            </div>
        
        </div>

    </div>
  
    <div class="col-md-6">
        <div class="box box-solid box-default">    
            <div class="box-header">
                <h3 class="box-title">Über diese Webseite</h3>
            </div> 
            <div class="box-body">
                <P>Diese Webseite ist im letzten Schuljahr im Rahmen des Seminarfachs Informatik im Jahrgang 12 neu konzipiert und (in Teilen) entwickelt worden. Neben dem Leihverfahren, wird auch die Ausleihe und Rückgabe der Bücher sowie die Bestandspflege der schuleigenen Bücher über die Webseite abgewickelt.</P>
                <p>Die Seite ist über das IServ-Menü permanent erreichbar. Schüler können hier nicht nur am Leihverfahren teilnehmen sondern später auch jederzeit einsehen, welche Bücher sie aktuell ausgeliehen haben. 
                </p>
            </div>
        </div> 

        
    </div>

</div>

<div style="margin-bottom:20px;">
    <a href="{{ url('user/buchleihe') }}" class="btn btn-primary">Weiter</a>
</div>

@stop