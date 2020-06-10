@extends('layouts.home')

@section('title', 'Buchausleihe im Schuljahr 2020/21')

@section('heading')
    <h4>Bestellung vom {{ $gewaehltAm }}</h4>
    <h4>{{ Auth::user()->vorname }} {{ Auth::user()->nachname }} ({{ Auth::user()->klasse }})</h4> 
@endsection

@section('content')
	
	@if ($errors->any())
	    <div class="alert alert-danger">
	        {{ $errors->first() }}
	    </div>
	@endif

    
    @if(!$leihliste->isEmpty())
    
        <h5 class="mt-4">Bestellte Leihbücher für Jahrgang {{ $schueler->jahrgang->jahrgangsstufe }} im Schuljahr {{ $schueler->jahrgang->schuljahr->schuljahr }} </h5>
        
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Titel</th> 
                    <th>ISBN</th>
                    <th>Fach</th>
                    <th>Verlag</th>
                    <th>Leihpreis</th>
                    <th>E-Book</th>             
                </tr>
            </thead>

            <tbody>

                @foreach ($leihliste as $bt)
                    <tr>
                        <td scope="row">{{ $bt->buchtitel->titel }}</td>
                        <td>{{ $bt->buchtitel->isbn }}</td>
                        <td>{{ $bt->buchtitel->fach->name }}</td>
                        <td>{{ $bt->buchtitel->verlag }}</td>
                        <td class="text-right">{{ number_format($bt->leihpreis, 2, ',', '') }} &euro;</td>
                        <td class="text-right">
                            @if($leihen->where('buchtitel_id', '=', $bt->id)
                                       ->where('ebook', '>', 0)
                                       ->first() 
                                       != null)
                                {{ number_format($bt->ebook, 2, ',', '') }} &euro;
                            @endif
                        </td> 
                    </tr>
                @endforeach

                <tr>
                    <td colspan="4">&nbsp;</td>
                    <td class="text-right">{{ number_format($leihliste->sum('leihpreis'), 2, ',', '') }} &euro;</td>
                    <td class="text-right">{{ number_format($leihlisteEbooks->sum('ebook'), 2, ',', '') }} &euro;</td>
                </tr>          

            </tbody>

        </table>

    @endif

    @if(!$verlaengernliste->isEmpty())

        <h5 class="mt-4">Verlängerte Leihbücher</h5>
        
        <table class="table table-striped"">
            <thead>
                <tr>
                    <th>Titel</th> 
                    <th>ISBN</th>
                    <th>Fach</th>
                    <th>Verlag</th>
                    <th>Leihpreis</th>
                    <th>E-Book</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($verlaengernliste as $bt)
                    <tr>
                        <td scope="row">{{ $bt->buchtitel->titel }}</td>
                        <td>{{ $bt->buchtitel->isbn }}</td>
                        <td>{{ $bt->buchtitel->fach->name }}</td>
                        <td>{{ $bt->buchtitel->verlag }}</td>
                        <td class="text-right">{{ number_format($bt->leihpreis, 2, ',', '') }} &euro;</td>
                         <td class="text-right">
                            @if($verlaengern->where('buchtitel_id', '=', $bt->id)
                                       ->where('ebook', '>', 0)
                                       ->first() 
                                       != null)
                                {{ number_format($bt->ebook, 2, ',', '') }} &euro;
                            @endif
                        </td> 
                    </tr>
                @endforeach

                <tr>
                    <td colspan="4">&nbsp;</td>
                    <td class="text-right">{{ number_format($verlaengernliste->sum('leihpreis'), 2, ',', '') }} &euro;</td>
                    <td class="text-right">{{ number_format($verlaengernlisteEbooks->sum('ebook'), 2, ',', '') }} &euro;</td>
                </tr>  

            </tbody>

        </table>

    @endif

    <h5>Die Summe der (nicht reduzierten) Leihpreise beträgt {{ number_format($summeLeihen, 2, ',', '') }} €.</h5>

    @if(!$kaufliste->isEmpty())
        
        <h5 class="mt-4">Kaufbücher</h5>
        
        <table class="table table-striped"">
            <thead>
                <tr>
                    <th>Titel</th> 
                    <th>ISBN</th>
                    <th>Fach</th>
                    <th>Verlag</th>
                    <th>Kaufpreis</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($kaufliste as $bt)
                    <tr>
                        <td scope="row">{{ $bt->buchtitel->titel }}</td>
                        <td>{{ $bt->buchtitel->isbn }}</td>
                        <td>{{ $bt->buchtitel->fach->name }}</td>
                        <td>{{ $bt->buchtitel->verlag }}</td>
                        <td class="text-right">{{ number_format($bt->kaufpreis, 2, ',', '') }} €</td>
                    </tr>
                @endforeach

                <tr>
                    <td colspan="4">&nbsp;</td>
                    <td class="text-right">{{ number_format($kaufliste->sum('kaufpreis'), 2, ',', '') }} €</td>
                </tr>  

            </tbody>

        </table> 

        <h5>Die Summe der Kaufpreise beträgt {{ number_format($summeKaufen, 2, ',', '') }} &euro;.</h5>

    @endif
            
@endsection