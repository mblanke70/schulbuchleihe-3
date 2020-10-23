@extends('layouts.home')

@section('title', 'Schulbuchleihe - Ursulaschule Osnabrück')

@section('heading')
   	<h4>Leihbücher und Ebooks im Schuljahr {{ $ausleiher->klasse->jahrgang->schuljahr->schuljahr }}</h4>
    <h4>{{ $ausleiher->vorname }} {{ $ausleiher->nachname }} ({{ $ausleiher->klasse->bezeichnung }})</h4> 
@endsection

@section('content')
	
	@if ($errors->any())
	    <div class="alert alert-danger">
	        {{ $errors->first() }}
	    </div>
	@endif

    @if(!empty($buecher))
    <h5>Leihbücher</h5>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titel</th>
                <th>Fach</th> 
                <th>ISBN</th>
                <th>Verlag</th>
                <th>Ausgabedatum</th>
                <th>Leihgebühr</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($buecher as $buch)
                <tr>
                    <td>{{ $buch->id }}</td>
                    <td>{{ $buch->buchtitel->titel }}</td>
                    <td>{{ $buch->buchtitel->fach->name }}</td>
                    <td>{{ $buch->buchtitel->isbn }}</td>
                    <td>{{ $buch->buchtitel->verlag }}</td>
                    <td>{{ $buch->ausleiher_ausgabe }}</td>
                    <td>{{ $buch->leihpreis }} €</td>
                </tr>
            @endforeach

            <tr>
                <td colspan="6" style="text-align: right; font-weight: 700;">Summe: </td>
                <td style="font-weight: 700;">{{ number_format($summe, 2, ',', '') }} €</td>
            </tr>

            @if($erm < 1)
                <tr>
                    <td colspan="6" style="text-align: right; font-weight: 700;">Summe ermäßigt ({{ $erm * 100 }}%): </td>
                    <td style="font-weight: 700;">{{ number_format($erm * $summe, 2, ',', '') }} €</td>
                </tr>
            @endif
        </tbody>

    </table> 
    @else
    <p>Keine Bücher ausgeliehen.</p>
    @endif

    @if(!empty($ebooks))
    <h5>Ebooks</h5>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Titel</th>
                <th>Fach</th> 
                <th>Verlag</th>
                <th>App</th>
                <th>Schlüssel</th>
                <th>Leihgebühr</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($ebooks as $ebook)
                <tr>
                    <td>{{ $ebook->buchtitel->buchtitel->titel }}</td>
                    <td>{{ $ebook->buchtitel->buchtitel->fach->name }}</td>
                    <td>{{ $ebook->buchtitel->buchtitel->verlag }}</td>
                    <td>{{ $ebook->app }}</td>
                    <td>{{ $ebook->schluessel}}
                    <td>{{ $ebook->leihpreis }} €</td>
                </tr>
            @endforeach

            <tr>
                <td colspan="5" style="text-align: right; font-weight: 700;">Summe: </td>
                <td style="font-weight: 700;">{{ number_format($summe_ebooks, 2, ',', '') }} €</td>
            </tr>

            @if($erm < 1)
                <tr>
                    <td colspan="6" style="text-align: right; font-weight: 700;">Summe ermäßigt ({{ $erm * 100 }}%): </td>
                    <td style="font-weight: 700;">{{ number_format($erm * $summe_ebooks, 2, ',', '') }} €</td>
                </tr>
            @endif
        </tbody>

    </table> 
    @else
    <p>Keine Ebooks ausgeliehen.</p>
    @endif

@endsection