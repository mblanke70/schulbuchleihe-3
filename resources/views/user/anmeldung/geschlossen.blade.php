@extends('layouts.home')

@section('title', 'Anmeldung zur Buchausleihe im Schuljahr 2019/20')

@section('heading')
    <h4>Anmeldung geschlossen</h4>
    <h4>{{ Auth::user()->vorname }} {{ Auth::user()->nachname }} ({{ Auth::user()->klasse }})</h4> 
@endsection

@section('content')
	
	<div class="row">
        <div class="col-md-6">

        	<p>Eine Anmeldung für die Schulbuchausleihe ist nicht mehr möglich.</p>

			<p>Es sind keine (neuen) Bücher zur Ausleihe bestellt worden.</p>

			<p>Die Bücherlisten für das Schuljahr 2019/20 können <a href="{{ url('user/buecherlisten') }}">hier</a> eingesehen werden.</p>

        </div>
        
   	    <div class="col-md-6">
	    
	    </div>
  	
  	</div>


@endsection