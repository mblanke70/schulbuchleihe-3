@extends('adminlte::page')

@section('title', 'Keine Verbindung')

@section('content_header')
    <h1>Keine Verbindung möglich</h1>
@stop

@section('content')

<div class="box">

	<div class="box-header with-border">
		<h3 class="box-title">{{ $iservUser["email"] }}</h3>
	</div>
	<!-- /.box-header -->

	<div class="box-body">
		Dieses IServ-Konto ist mit keinem Konto der Schulbuchausleihe verknüpft. Entweder es gibt für den IServ-Nutzer noch kein Konto bei der Schulbuchausleihe, oder das Konto ist falsch verknüpft worden. Zur Behebung des Problems bitte den Administrator informieren.
	</div>

	<!-- /.box-body -->
	<div class="box-footer">
		The footer of the box
	</div>
	<!-- box-footer -->

</div>
<!-- /.box -->

@stop