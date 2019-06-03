@extends('layouts.home')

@section('title', 'Schulbuchleihe - Ursulaschule Osnabrück')

@section('heading')
   	<h4>Bücherliste für den Jahrgang {{ $jahrgang->jahrgangsstufe }} </h4>
    <h4>{{ Auth::user()->vorname }} {{ Auth::user()->nachname }} ({{ Auth::user()->klasse }})</h4> 
@endsection

@section('content')
	
	@if ($errors->any())
	    <div class="alert alert-danger">
	        {{ $errors->first() }}
	    </div>
	@endif

    <form action="{{ url('user/buecherlisten') }}" method="POST" role="form">

        {{ csrf_field() }}

    	<div class="input-group mb-3">
    		<div class="input-group-prepend">
    			<label class="input-group-text" for="jahrgang">Jahrgang</label>
    	  	</div>
    		<select class="custom-select" id="jahrgang" name="jahrgang" onchange="this.form.submit()">
    			@foreach ($jahrgaenge as $jg)
    		    	<option value="{{ $jg->id }}" 
    		    		@if ($jahrgang->jahrgangsstufe==$jg->jahrgangsstufe) selected @endif 
    		    	>
    		    		{{ $jg->jahrgangsstufe }} ({{ $jg->schuljahr->schuljahr }})
    		    	</option>	
    			@endforeach
    	  	</select>
    	</div>

    </form>

	<table class="table table-striped">
        <thead>
            <tr>
                <th>Titel</th> 
                <th>ISBN</th>
                <th>Verlag</th>
                <th>Leihpreis</th>
                <th>Kaufpreis</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($buecherliste as $bt)
                <tr>
                    <td scope="row">{{ $bt->buchtitel->titel }}</td>
                    <td>{{ $bt->buchtitel->isbn }}</td>
                    <td>{{ $bt->buchtitel->verlag }}</td>
                    <td>@isset($bt->leihpreis) {{ $bt->leihpreis }} &euro; @endisset</td>
                    <td>@isset($bt->kaufpreis) {{ $bt->kaufpreis }} &euro; @endisset</td>
                </tr>
            @endforeach

        </tbody>

    </table> 

@endsection