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

    <form action="{{ url('user/buecherlisten/'.$schuljahr_id) }}" method="POST" role="form">

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
                <th>Fach</th>
                <th>ISBN</th>
                <th>Verlag</th>
                <th class="text-right">Leihpreis</th>
                <th class="text-right">Kaufpreis</th>
                <th class="text-right">E-Book</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($buecherliste as $bt)
                <tr>
                    <td scope="row">{{ $bt->buchtitel->titel }}</td>
                    <td>{{ $bt->buchtitel->fach->name }}</td>
                    <td>{{ $bt->buchtitel->isbn }}</td>
                    <td>{{ $bt->buchtitel->verlag }}</td>
                    <td class="text-right">
                        @isset($bt->leihpreis) 
                            {{ number_format($bt->leihpreis, 2, ',', '') }} € 
                        @endisset
                    </td>
                    <td class="text-right">
                        @isset($bt->kaufpreis)
                            {{ number_format($bt->kaufpreis, 2, ',', '') }} €
                        @endisset
                    </td>
                    <td class="text-right">
                        @isset($bt->ebook)     
                            {{ number_format($bt->ebook, 2, ',', '') }} €
                        @endisset
                    </td>
                </tr>
            @endforeach

        </tbody>

    </table> 

@endsection