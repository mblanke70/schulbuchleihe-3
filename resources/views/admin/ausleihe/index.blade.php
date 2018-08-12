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
@stop