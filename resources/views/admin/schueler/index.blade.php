@extends('adminlte::page')

@section('title', 'Schueler')

@section('content_header')
    <h1>Schüler</h1>
@stop

@section('content')

<div class="box">

	<div class="box-header with-border">
		<h3 class="box-title">Schüler</h3>
		<div class="box-tools pull-right">
	  		<!-- Buttons, labels, and many other things can be placed here! -->
	  		<!-- Here is a label for example -->
	  		<a href="{{ url('admin/schueler/create') }}" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-plus"></i> Create</a>

	  		<a href="{{ url('admin/versetzen') }}" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-plus"></i> Versetzen</a>
		  
		</div>
		<!-- /.box-tools -->
	</div>
	<!-- /.box-header -->

	<div class="box-body">

		<table id="schueler" class="display" cellspacing="0" width="100%">

	        <thead>

	            <tr>
	                <th>ID</th>
	                <th>Name</th>
	                <th>Vorname</th>
	                <th>Klasse</th>
	                <th>IServ-ID</th>
	                <!--<th>WinSchool-ID</th>-->
	                <!--<th>ist Admin?</th>-->
	                <th>Aktion</th>
	            </tr>

	        </thead>

    	</table>

	</div>

	<!-- /.box-body -->
	<div class="box-footer">
		The footer of the box
	</div>
	<!-- box-footer -->
</div>
<!-- /.box -->

@stop

@section('js')
<script>
	$(function() {
	    $('#schueler').DataTable({
	        processing: true,
	        serverSide: true,
	        ajax: '{!! url('admin/getUserData') !!}',
	        columns: [
	            { data: 'id', name: 'id' },
	            { data: 'nachname', name: 'nachname' },
	            { data: 'vorname', name: 'vorname' },
	            { data: 'klasse', name: 'klasse' },
	            { data: 'iserv_id', name: 'iserv_id' },
	            { data: 'action', name: 'action', orderable: false, searchable: false}
	        ]
	    });
	});
</script>
@stop