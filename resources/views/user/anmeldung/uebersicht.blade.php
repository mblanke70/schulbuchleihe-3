@extends('layouts.home')

@section('title', 'Buchausleihe im Schuljahr 2019/20')

@section('heading')
    <h4>Bestellung vom {{ $gewaehlt }}</h4>
    <h4>{{ Auth::user()->vorname }} {{ Auth::user()->nachname }} ({{ Auth::user()->klasse }})</h4> 
@endsection

@section('content')
	
	@if ($errors->any())
	    <div class="alert alert-danger">
	        {{ $errors->first() }}
	    </div>
	@endif
    
    <h5 class="mt-4">Neu ausgeliehene Bücher (Ausgabe zu Beginn des neuen Schuljahres)</h5>
    
    <table class="table table-striped"">
        <thead>
            <tr>
                <th>Titel</th> 
                <th>ISBN</th>
                <th>Fach</th>
                <th>Verlag</th>
                <th>Leihpreis</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($leihliste as $bt)
                <tr>
                    <td scope="row">{{ $bt->buchtitel->titel }}</td>
                    <td>{{ $bt->buchtitel->isbn }}</td>
                    <td>{{ $bt->buchtitel->fach->name }}</td>
                    <td>{{ $bt->buchtitel->verlag }}</td>
                    <td>{{ $bt->leihpreis }} &euro;</td>
                </tr>
            @endforeach

        </tbody>

    </table> 

    <h5 class="mt-4">Verlängerte Bücher</h5>
    
    <table class="table table-striped"">
        <thead>
            <tr>
                <th>Titel</th> 
                <th>ISBN</th>
                <th>Fach</th>
                <th>Verlag</th>
                <th>Leihpreis</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($verlaengernliste as $bt)
                <tr>
                    <td scope="row">{{ $bt->buchtitel->titel }}</td>
                    <td>{{ $bt->buchtitel->isbn }}</td>
                    <td>{{ $bt->buchtitel->fach->name }}</td>
                    <td>{{ $bt->buchtitel->verlag }}</td>
                    <td>{{ $bt->leihpreis }} &euro;</td>
                </tr>
            @endforeach

        </tbody>

    </table> 

    <h5>Die Summe der reduzierten Leihpreise beträgt {{ number_format($summeLeihenReduziert, 2, ',', '') }} &euro;.</h5>

    <h5 class="mt-4">Bücher, die selbst gekauft werden</h5>
    
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
                    <td>{{ $bt->kaufpreis }} &euro;</td>
                </tr>
            @endforeach

        </tbody>

    </table> 

    <h5>Die Summe der Kaufpreise beträgt {{ number_format($summeKaufen, 2, ',', '') }} &euro;.</h5>
            
@endsection