@extends('adminlte::page')

@section('title', 'Meine Bücher')

@section('content_header')
    <h1>Meine Leihbücher</h1>
    <h4>{{ $schueler->vorname }} {{ $schueler->nachname }} ({{ $schueler->klasse->bezeichnung }})</h4>
@stop

@section('content')

<div class="box box-solid box-success">    

    <div class="box-header">
        <h3 class="box-title">Leihbücher</h3>
    </div>
    
    <div class="box-body">  

        <table id="leihen" class="table table-striped"">
            <thead>
                <tr>
                    <th>Buch-ID</th>
                    <th>Titel</th> 
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
                        <td>{{ $buch->buchtitel->isbn }}</td>
                        <td>{{ $buch->buchtitel->verlag }}</td>
                        <td>{{ $buch->ausleiher_ausgabe }}</td>
                        <td>{{ number_format($buch->buchtitel->leihgebuehr, 2, ',', '') }} &euro;</td>
                    </tr>
                @endforeach

                    <tr>
                        <td colspan="5" style="text-align: right;">Summe:</td>
                        <td>{{ number_format($summe, 2, ',', '') }} &euro;</td>
                    </tr>
                
                @if($schueler->bestaetigt > 0)
                    <tr>
                        <td colspan="5" style="text-align: right;">
                            Summe ermäßigt (-  ... %):
                        </td>
                        <td>{{ number_format($summeErm, 2, ',', '') }} &euro;</td>
                    </tr>
                @endif
            </tbody>

        </table> 
    </div>       

</div> 

<div class="box box-solid box-warning">    

    <div class="box-header">
        <h3 class="box-title">Kostenaufstellung</h3>
    </div>
    
    <div class="box-body">  

        <table class="table table-striped"">
            <thead>
             
            </thead>

            <tbody>
                <p>
                    Die 
                        @if($schueler->bestaetigt > 0)
                            ermäßigte
                        @endif
                    Leihgebühr beträgt: {{ number_format($summeErm, 2, ',', '') }} €.
                </p>
                <p>
                    Dazu kommen (für alle Schüler) Kosten für:
                    <ul>
                        <li>Kopiergeld (5,00 &euro;)</li>
                        <li>Beitrag für Eltern- und SV-Arbeit (1,50 &euro;)</li>
                    </ul>
                </p>

                @if($schueler->pauschale > 0)
                <p>
                    {{ $schueler->vorname }} ist das jüngste Geschwisterkind an der Ursulaschule, deshalb entstehen zusätzlich folgende Kosten:
                    <ul>
                        <li>Nutzungsgebühr für das MS-Office Paket (6,00 &euro;)</li>
                        <li>Jahresbericht (4,50 &euro;)</li>
                    </ul>
                </p>
                @endif

                <p>
                    Insgesamt ergibt sich ein Rechnungsbetrag in Höhe von {{ number_format($summeErm + $zusatzkosten, 2, ', ', '') }} €.
                </p>
                <p>
                    Dieser Betrag wird in den nächsten Tagen von dem Konto eingezogen, von dem auch das Schulgeld für Ihr Kind eingezogen wird.
                </p>
            </tbody>
        </table> 
    </div>       

</div> 

@stop
 