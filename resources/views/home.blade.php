@extends('adminlte::page')

@section('title', 'Ursulaschule Osnabrück')

@section('content_header')
    <h1>Schulbuchleihe der Ursulaschule Osnabrück</h1>
@stop

@section('content')
    <h4>Herzlich Willkommen auf den Seiten der Schulbuchleihe.</h4>
    <p>Um das Programm nutzen zu können, müssen Sie sich mit Ihrem IServ-Account anmelden.</p>
    <div class="form-group">
	    <form action="{{ url('login/iserv') }}" method="GET" role="form">

			{{ csrf_field() }}
			
			<div>
		    	<button type="submit" class="btn btn-primary">Login mit IServ</button>
			</div>

		</form>
	</div>
@stop