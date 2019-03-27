@extends('adminlte::page')

@section('title', 'Ausleihe')

@section('content_header')
    <h1>
    	<a class="btn btn-primary" href="{{ url('admin/ausleihe') }}" role="button">
        	<i class="fa fa-chevron-circle-up fa-lg"></i>
    	</a>
    	Ausleihe ({{ $klasse->bezeichnung }} )
    </h1>
@stop

@section('content')

<div class="row">

	@for ($i = 0; $i < 3; $i++)
	<div class="col-md-4">
		<div class="table-responsive">		
			<table class="display table table-hover">
				<thead>	
					<th width="40%">Nachname</th>
					<th width="40%">Vorname</th>
					<th width="10%"></th>
				</thead>
				<tbody>
					@foreach ($gruppen[$i] as $a)
						<tr>
							<td width="50%"><a href="{{ url('admin/ausleihe/'.$a->klasse_id.'/'.$a->id)  }}">
								{{ $a->nachname }} </a></td>
							<td width="50%"><a href="{{ url('admin/ausleihe/'.$a->klasse_id.'/'.$a->id)  }}">
								{{ $a->vorname }} </a></td>
							<td>
								<a href="{{ url('admin/ausleihe/buecherliste/'.$a->klasse_id.'/'.$a->id)  }}">
									<i class="fa fa-print fa-lg"></i>
								</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	@endfor
	
</div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            var table = $('.display').DataTable( {
                searching: false, 
                info: false, 
                paging: false,
            } );
        } );
    </script>
@stop