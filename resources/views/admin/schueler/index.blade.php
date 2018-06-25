@extends('adminlte::page')

@section('title', 'Schueler')

@section('content_header')
    <h1>Schüler</h1>
@stop

@section('content')

<div class="box-body">
    <a class="btn btn-success" href="{{ url('admin/schueler/create') }}">Neuer Schüler</a>
</div>

<div class="box">

	<div class="box-header with-border">
		<h3 class="box-title">Schüler</h3>
		<div class="box-tools pull-right">
	  		<!-- Buttons, labels, and many other things can be placed here! -->
	  		<!-- Here is a label for example -->
		  	<span class="label label-primary">Label</span>
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
	                <th>IServ-Email</th>
	                <!--<th>WinSchool-ID</th>-->
	                <!--<th>ist Admin?</th>-->
	            </tr>

	        </thead>

	        <tfoot>

	            <tr>
	            	<th>ID</th>
	                <th>Name</th>
	                <th>Vorname</th>
	                <th>Klasse</th>
	                <th>IServ-ID</th>
	                <th>IServ-Email</th>
	                <!--<th>WinSchool-ID</th>-->
	                <!--<th>ist Admin?</th>-->
	            </tr>

	        </tfoot>

	        <tbody>

	        	@foreach ($schueler as $s)
	            
	                <tr>
	                    <td> {{ $s->id }} </td>
	                    <td> {{ $s->nachname }} </td>
	                    <td> {{ $s->vorname }} </td>
						<td> {{ $s->klasse }} </td>
	                    <td> {{ $s->iserv_id }} </td>
	                    <td> {{ $s->email }} </td>
	                    <!--<td> {{ $s->winschool_id }} </td>-->
	                    <!--<td> {{ $s->isAdmin }} </td>-->
	                </tr>

	            @endforeach

	        </tbody>

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
        $(document).ready(function() {
            var table = $('#schueler').DataTable( {
                rowReorder: true,
                stateSave: true
            } );
        } );
    </script>
@stop