@extends('adminlte::page')

@section('title', 'Klassen und Jahrgänge')

@section('content_header')
    <h1>Klassen und Jahrgänge</h1>
@stop

@section('content')

<div class="row">
	<div class="col-md-6">
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">Klassen</h3>
				<div class="box-tools pull-right">
					<a class="btn btn-block btn-success" href="{{ url('admin/klassen/create') }}">Neue Klasse</a>   				
				</div>
				<!-- /.box-tools -->
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<table id="klassen" class="display" cellspacing="0" width="100%">
			        <thead>
			            <tr>
			                <th>ID</th>
			                <th>Pos</th>
			                <th>Bezeichnung</th>
			                <th>Jahrgang</th>
			            </tr>
			        </thead>
			        <tfoot>
			            <tr>
			            	<th>ID</th>
			                <th>Pos</th>
			                <th>Bezeichnung</th>
			                <th>Jahrgang</th>
			            </tr>
			        </tfoot>
			        <tbody>
			        	@foreach ($klassen as $k)
			                <tr>
			                    <td> {{ $k->id }} </td>
			                    <td> {{ $k->pos }} </td>
			                    <td> {{ $k->bezeichnung }} </td>
			                    <td> {{ $k->jahrgang->jahrgangsstufe }} </td>
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
	</div>

	<div class="col-md-6">
			<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">Jahrgänge</h3>
				<div class="box-tools pull-right">
			  		<!-- Buttons, labels, and many other things can be placed here! -->
			  		<!-- Here is a label for example -->
				  	<!--<span class="label label-primary">Label</span>-->
				</div>
				<!-- /.box-tools -->
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<table id="jahrgaenge" class="display" cellspacing="0" width="100%">
			        <thead>
			            <tr>
			                <th>ID</th>
			                <th>Pos</th>
			                <th>Jahrgangsstufe</th>
			            </tr>
			        </thead>
			        <tfoot>
			            <tr>
			            	<th>ID</th>
			                <th>Pos</th>
			                <th>Jahrgangsstufe</th>
			            </tr>
			        </tfoot>
			        <tbody>
			        	@foreach ($jahrgaenge as $j)
			                <tr>
			                    <td> {{ $j->id }} </td>
			                    <td> {{ $j->pos }} </td>
			                    <td> {{ $j->jahrgangsstufe }} </td>
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
	</div>
</div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            var table1 = $('#klassen').DataTable( {
                rowReorder: true,
                stateSave: true
            } );

			var table2 = $('#jahrgaenge').DataTable( {
                rowReorder: true,
                stateSave: true
            } );            
        } );
    </script>
@stop