@extends('layouts.home')

@section('title', 'Anmeldung zur Buchausleihe im Schuljahr 2019/20')

@section('heading')
    <h4>Anmeldung (Schritt 1/4)</h4>
    <h4>{{ Auth::user()->vorname }} {{ Auth::user()->nachname }} ({{ Auth::user()->klasse }})</h4> 
@endsection

@section('content')
	
	@if ($errors->any())
	    <div class="alert alert-danger">
	        {{ $errors->first() }}
	    </div>
	@endif

<form action="{{ url('user/anmeldung/schritt1') }}" method="POST" role="form">

    {{ csrf_field() }}

	<div class="row">
        <div class="col-sm-3 col-md-6">
        	<h4>Erm&auml;&szlig;igung auf den Leihpreis</h4>
        	<p>Familien mit 3 oder mehr schulpflichtigen Kindern zahlen nur 80% des Leihpreises. Zum Nachweis geben Sie bitte bis zum 18.6. Schulbescheinigungen der Kinder, die nicht die Ursulaschule besuchen - sofern sich eine Ver&auml;nderung ergeben hat - im Sekretariat ab.</p>

        	<div class="input-group mb-3">
				<div class="input-group-prepend">
					<label class="input-group-text" for="ermaessigung">Ermäßigung</label>
	  			</div>
        	
                <select id="ermaessigung" class="custom-select" name="ermaessigung">
                    <option value="0" selected>keine Erm&auml;&szlig;igung</option>
                    <option value="1">20% Erm&auml;&szlig;igung (3 Kinder)</option>
                    <option value="2">100% Erm&auml;&szlig;igung (befreit)</option>
                </select>
            </div>

        </div>
        <div class="col-sm-9 col-md-6">
	       	<h4>Jahrgang im Schuljahr 2019/20</h4>
            <p>Geben Sie hier an, in welchem Jahrgang sich ihr Kind im nächsten Schuljahr befindet. (Es sollte der richtige Jahrgang vorausgewählt sein.)</p>
            <div class="input-group mb-3">
				<div class="input-group-prepend">
					<label class="input-group-text" for="jahrgang">Jahrgang</label>
	  			</div>
			  	<select class="custom-select" id="jahrgang" name="jahrgang">
				@foreach ($jahrgaenge as $jg)
			    	<option value="{{ $jg->id }}" 
			    		@if ($jahrgang==$jg->jahrgangsstufe) selected @endif 
			    	>
			    		{{ $jg->jahrgangsstufe }} ({{ $jg->schuljahr->schuljahr }})
			    	</option>	
				@endforeach
			  	</select>
			</div>

        </div>
  	</div>

	<div>
		<button type="submit" class="btn btn-primary">Weiter</button>
	</div>
	
</form>

@endsection