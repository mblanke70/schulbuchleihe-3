@extends('adminlte::page')

@section('title', 'Leihverfahren')

@section('content_header')
    <h1>Übersicht: Leih- und Kaufbücher</h1>
    <h4>{{ Auth::user()->vorname }} {{ Auth::user()->nachname }} ({{ Auth::user()->klasse }})</h4> 
@stop

@section('content')

<div class="box box-solid box-danger">    

    <div class="box-header">
        <h3 class="box-title">Das Bestellverfahren ist abgeschlossen!</h3>
    </div>
    
    <div class="box-body">  
        Es können keine Bücher mehr über diese Webseite zur Ausleihe ausgewählt werden.
    </div>       

</div> 

@stop