@extends('layouts.home')

@section('title', 'Anmeldung zur Buchausleihe im Schuljahr 2020/21')

@section('heading')
    <h4>Anmeldung (Schritt 2/5)</h4>
    <h4>{{ Auth::user()->vorname }} {{ Auth::user()->nachname }} ({{ Auth::user()->klasse }})</h4> 
@endsection

@section('content')
	
	@if ($errors->any())
	    <div class="alert alert-danger">
	        {{ $errors->first() }}
	    </div>
	@endif

    <h5 class="box-title">Wahlabfragen für den Jahrgang {{ $jg->jahrgangsstufe }}</h5>

	<form action="{{ url('user/anmeldung/schritt2') }}" method="POST" role="form">

    {{ csrf_field() }}

    @foreach ($abfragen as $abfr)

        <div class="row pt-2">
        
            <div class="col-md-3">
                <strong>{{ $abfr->titel }}</strong>
            </div>
        
            @foreach ($abfr->antworten as $antw)
             
            <div class="col-md-3">
	            <div class="custom-control custom-radio custom-control-inline">
	                @if ($abfr->child_id)
	                    <!-- Abfrage für die eine Unter-Abfrage existiert -->
	                    @if ($antw->fach_id)
	                        <input type="radio" class="custom-control-input" id="antw-{{ $antw->id }}" name ="abfrage[{{ $abfr->id}}]" value="{{ $antw->id }}" checked
	                        onclick="show('abfr-{{ $abfr->child_id }}')"/>
	                    @else
	                        <input type="radio" class="custom-control-input" id="antw-{{ $antw->id }}" name ="abfrage[{{ $abfr->id}}]" value="{{ $antw->id }}" checked
	                        onclick="hide('abfr-{{ $abfr->child_id }}')"/>
	                    @endif
	                @else
	                    <!-- Abfrage ohne Unter-Abfrage -->
	                    <input type="radio" class="custom-control-input" id="antw-{{ $antw->id }}" name ="abfrage[{{ $abfr->id}}]" checked
	                    value="{{ $antw->id }}" />
	                @endif
	    			<label class="custom-control-label" for="antw-{{ $antw->id }}">{{ $antw->titel }}</label>
    			</div>
            </div>


            @endforeach

        </div>

        @if ($abfr->child_id)
        
        <div id="abfr-{{ $abfr->child_id }}" class="row p-3 bg-light" style="display:none;">

            <div class="col-md-3">&#8594; {{ $abfr->child->titel }}</div>
                
            @foreach ($abfr->child->antworten as $antw)

	        <div class="col-md-3">
            	<div class="custom-control custom-radio custom-control-inline">

	                <input type="radio" class="custom-control-input" name ="abfrage[{{ $abfr->child_id }}]" id="antw-{{ $antw->id }}" value="{{ $antw->id }}"  checked  />
	                <label class="custom-control-label" for="antw-{{ $antw->id }}">{{ $antw->titel }}</label>
	            
	            </div>
			</div>

            @endforeach

        </div>            
        
        @endif  
                
    @endforeach

    <div class="pt-4">
		<button type="submit" class="btn btn-primary">Weiter</button>
	</div>

	</form>

@endsection

@stack('js')
<script>
    function show(id){
        $('#' + id).show();
    }
    
    function hide(id){
        //$('#' + id).find('input:radio').each(function () { $(this).attr('checked', false); });
        $('#' + id).hide();
    }   
</script>
@endstack