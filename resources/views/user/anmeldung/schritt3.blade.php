@extends('layouts.home')

@section('title', 'Anmeldung zur Buchausleihe im Schuljahr 2020/21')

@section('heading')
    <h4>Anmeldung (Schritt 3/5)</h4>
    <h4>{{ Auth::user()->vorname }} {{ Auth::user()->nachname }} ({{ Auth::user()->klasse }})</h4> 
@endsection

@section('content')
	
	@if ($errors->any())
	    <div class="alert alert-danger">
	        {{ $errors->first() }}
	    </div>
	@endif

    <h5 class="box-title">Bücherliste für den Jahrgang {{ $jahrgang->jahrgangsstufe }}</h5>

	<form action="{{ url('user/anmeldung/schritt3') }}" method="POST" role="form">

	    {{ csrf_field() }}

        <div class="table-responsive">
            <table id="buchtitel" class="table table-striped">
                <thead>
                    <tr>
                        <th>Titel</th> 
                        <th>Fach</th>
                        <th>ISBN</th>
                        <th>Verlag</th>
                        <th>Preis</th>
                        <th>Leihgebühr</th>
                        <th>Leihen</th>
                        <th>Verlängern</th>
                        <th>Kaufen</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($buecherliste as $bt)
                        <tr>
                            <td scope="row">{{ $bt->buchtitel->titel }}</td>
                            <td>{{ $bt->buchtitel->fach->code }}</td>
                            <td>{{ $bt->buchtitel->isbn }}</td>
                            <td>{{ $bt->buchtitel->verlag }}</td>
                            <td class="text-right">
                            @isset($bt->kaufpreis)
                                {{ number_format($bt->kaufpreis, 2, ',', '') }} €
                            @endisset
                            </td>
                            <td class="text-right">
                            @isset($bt->leihpreis)
                                {{ number_format($bt->leihpreis, 2, ',', '') }} €
                            @endisset
                            </td>
                            <td class="text-center">
                            	@isset( $bt->leihpreis )
                            		@if( empty($leihbuecher) ||           
                                            !$leihbuecher->contains($bt->buchtitel->id) )
                                		<div class="custom-control custom-radio">
    	                                    <input type="radio" id="leihen-{{ $bt->id }}" class="custom-control-input" value="1" checked name="wahlen[{{ $bt->id }}]" @if (old('wahlen.'.$bt->id) == 1) checked @endif />
    	                                    <label class="custom-control-label" for="leihen-{{ $bt->id }}"></label>
    									</div>
                                    @endif
                                @endisset
                            </td>
                            <td class="text-center">                            	    
                                @if( !empty($leihbuecher) && 
                                        $leihbuecher->contains($bt->buchtitel->id) )
                           			<div class="custom-control custom-radio">
                             	   	<input type="radio" id="verlaengern-{{ $bt->id }}" class="custom-control-input" value="2" checked name="wahlen[{{ $bt->id }}]" @if (old('wahlen.'.$bt->id) == 2) checked @endif/>
                             	   	<label class="custom-control-label" for="verlaengern-{{ $bt->id }}"></label>
									</div>
                                @endif
                            </td>
                            <td class="text-center">
                            	@isset( $bt->kaufpreis )
                                	<div class="custom-control custom-radio">
                                        <input type="radio" id="kaufen-{{ $bt->id }}" class="custom-control-input" value="3" name="wahlen[{{ $bt->id }}]" @if (old('wahlen.'.$bt->id) == 3 || empty($bt->leihpreis)) checked @endif/>
                                        <label class="custom-control-label" for="kaufen-{{ $bt->id }}"></label>
                                    </div>
                                @endisset
                            </td>
                
                        </tr>
                    @endforeach

                </tbody>

            </table>           

        </div>

	    <div>
	        <button type="submit" class="btn btn-primary">Weiter</button>
	    </div>

	</form>

@endsection