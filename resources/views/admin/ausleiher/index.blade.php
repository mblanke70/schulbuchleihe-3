@extends('adminlte::page')

@section('title', 'Ausleiher')

@section('content_header')
    <h1>Ausleiher</h1>
@stop

@section('content')

<div class="box">

	<div class="box-header with-border">
		<h3 class="box-title">Ausleiher</h3>
		<div class="box-tools pull-right">
			<div class="box-tools pull-right">
			  	<span class="label label-primary">{{ $schuljahr->schuljahr }}</span>
			</div>
	  		<!-- Buttons, labels, and many other things can be placed here! -->
	  	<!--	<a href="{{ url('admin/ausleiher/create') }}" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-plus"></i> Create</a> -->
		</div>
		<!-- /.box-tools -->
	</div>
	<!-- /.box-header -->

	<div class="box-body">

		<table id="ausleiher" class="display" cellspacing="0" width="100%">

	        <thead>

	            <tr>
	                <th>ID</th>
	                <th>Vorname</th>
	                <th>Nachname</th>
	                <th>Klasse</th>
	                <th>Ermässigung</th>
	                <!--<th>Aktion</th>-->
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
	    $('#ausleiher').DataTable({
	        processing: true,
	        serverSide: true,
	        ajax: '{!! url('admin/getAusleiherData') !!}',
	        columns: [
	            { data: 'id', name: 'id' },
	            { data: 'user.vorname', name: 'vorname' },
   	            { data: 'user.nachname', name: 'nachname' },
	            { data: 'klasse.bezeichnung', name: 'klasse' },
	            { data: 'erm_bestaetigt', name: 'erm_bestaetigt' },
	            //{ data: 'action', name: 'action', orderable: false, searchable: false}
	        ]
	    });
	});
</script>
@stop