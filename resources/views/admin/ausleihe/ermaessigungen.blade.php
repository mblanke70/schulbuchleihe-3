@extends('adminlte::page')

@section('title', 'Ermäßigungen')

@section('content_header')
    <h1>Ermäßigungen</h1>
@stop

@section('content')

<div class="box-body">
	
</div>

<div class="box">

	<div class="box-header with-border">
		<h3 class="box-title">Ermäßigungen</h3>
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
	                <th>Ermäßigung</th>
	                <th>bestätigt</th>
	            </tr>

	        </thead>

	        <tbody>

	        	@foreach($schueler as $s)
 					<tr>			
	 					<td>{{ $s->id }}</td>
		                <td>{{ $s->nachname }}</td>
		                <td>{{ $s->vorname }}</td>
		                <td>{{ $s->klasse }}</td>
		                <td>
	                   		<span style="display:none">{{ $s->ermaessigung }}</span>

		                	<form action="{{ url('admin/ausleihe/ermaessigungen/'.$s->id) }}" method="POST">
                        		{{ csrf_field() }}   
                  		        {{ method_field('PUT') }}

			                	<select class="buchleihe-ermaessigung" name="ermaessigung">
	                        		<option value="10" @if($s->ermaessigung==10) selected @endif>keine</option>
	                        		<option value="8" @if($s->ermaessigung==8) selected @endif>20%</option>
	                        		<option value="0" @if($s->ermaessigung==0) selected @endif>100%</option>
	                    		</select>
	                    	</form>
		                </td>
		                <td>
		                	<span style="display:none">{{ $s->bestaetigt }}</span>
		                	<form action="{{ url('admin/ausleihe/ermaessigungen/'.$s->id) }}" method="POST">
                        		{{ csrf_field() }}   
		                	 	<input class="form-check-input" type="checkbox" name="bestaetigt" @if($s->bestaetigt) checked @endif />
		                	</form>
		                </td>
		            </tr>
	        	@endforeach

	        </tbody>

    	</table>

	</div>

	<!-- /.box-body -->
</div>
<!-- /.box -->

@stop

@section('js')
<script>
	$(function() {
	    $('#schueler').DataTable({
	      	rowReorder: true,
            stateSave: true
	    });
	});

	$('form input:checkbox').on('change', function(){
        $(this).closest('form').submit();
    });

    $('form select').on('change', function(){
        $(this).closest('form').submit();
    });
</script>
@stop