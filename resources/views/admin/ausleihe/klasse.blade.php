@extends('adminlte::page')

@section('title', 'Ausleihe')

@section('content_header')
    <h1>Ausleihe ({{ $klasse->bezeichnung }})</h1>
@stop

@section('content')

<div class="table-responsive">		
	<table id="schueler" class="display table table-hover">
		<thead>	
			<th width="20%">ID</th>
			<th width="30%">Nachname</th>
			<th width="30%">Vorname</th>
		</thead>
		<tbody>
			@foreach ($schueler as $s)
				<tr>
					<td width="20%">

						<a href="{{ url('admin/ausleihe/'.$s->klassengruppe->id.'/'.$s->id) }}">
						{{ $s->id }}</a></td>
					<td width="30%"><a href="{{ url('admin/ausleihe/'.$s->klassengruppe->id.'/'.$s->id)  }}">
						{{ $s->nachname }} </a></td>
					<td width="30%"><a href="{{ url('admin/ausleihe/'.$s->klassengruppe->id.'/'.$s->id)  }}">
						{{ $s->vorname }} </a></td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>

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