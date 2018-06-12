@extends('adminlte::page')

@section('title', 'Ausleihe')

@section('content_header')
    <h1>Ausleihe</h1>
@stop

@section('content')

<div class="row">

	@foreach ($jahrgaenge as $jg)
	<div class="col-md-2">
		<div class="box box-solid box-default">            
	    	<div class="box-header with-border">                
	            <div class="box-title">
	            	Jahrgang {{ $jg->jahrgangsstufe }}
	            </div>
	        </div>

	        <div>
	        	<div class="box-body">
	        		<ul>
	        		@foreach ($klassen->where('jahrgang_id', $jg->id) as $k)
						<li><a href="{{ url('admin/ausleihe/'.$k->id) }}"> {{ $k->bezeichnung }} </a></li>
					@endforeach
					</ul>
	            </div>
	         </div>
	    </div>
	</div>
    @endforeach

</div>


<div class="table-responsive">		
	<table id="klassen" class="display table table-hover">
		<thead>	
			<th width="30%">ID</th>
			<th width="70%">Klasse</th>
		</thead>
		<tbody>
			@foreach ($klassen as $k)
				<tr>
					<td><a href="{{ url('admin/ausleihe/'.$k->id) }}">
						{{ $k->id }}</a></td>
					<td><a href="{{ url('admin/ausleihe/'.$k->id) }}">
						{{ $k->bezeichnung }} </a></td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>

@stop

@section('js')
    <script>
        $(document).ready(function() {
            var table = $('#klassen').DataTable( {
                rowReorder: true,
                stateSave: true
            } );
        } );
    </script>
@stop