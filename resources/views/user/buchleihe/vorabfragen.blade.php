@extends('adminlte::page')

@section('title', 'Leihverfahren')

@section('content_header')
    <h1>Leihverfahren: Vorabfragen zum Leihverfahren (Schritt 1/4)</h1>
    <h4>{{ Auth::user()->vorname }} {{ Auth::user()->nachname }} ({{ Auth::user()->klasse }})</h4>    
@stop

@section('content')

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="progress">
  <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
</div>

<form action="{{ url('user/buchleihe/vorabfragen') }}" method="POST" role="form">

{{ csrf_field() }}

<div class="row">
    <div class="col-md-6">
        <div class="box box-solid box-default">
            <div class="box-header">
                <h3 class="box-title">Bekommen Sie eine Erm&auml;&szlig;igung auf den Buchleihpreis?</h3>
            </div>
            <div class="box-body">
                <p>Familien mit 3 oder mehr schulpflichtigen Kindern zahlen nur 80% des Leihpreises. Zum Nachweis geben Sie bitte bis zum 18.6. Schulbescheinigungen der Kinder, die nicht die Ursulaschule besuchen - sofern sich eine Ver&auml;nderung ergeben hat - im Sekretariat ab.</p>

                <div class="form-group">
                    <label for="buchleihe-ermaessigung">Ermäßigung auf Leihpreis</label>
                    <select class="buchleihe-ermaessigung" name="ermaessigung">
                        <option></option>
                        <option value="10">keine Erm&auml;&szlig;igung</option>
                        <option value="8">20% Erm&auml;&szlig;igung (3 Kinder)</option>
                        <option value="0">100% Erm&auml;&szlig;igung (befreit)</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-solid box-default">
            <div class="box-header">
                <h3 class="box-title">Ist ein &auml;lteres Geschwisterkind an der Ursulaschule?</h3>
            </div>
            <div class="box-body">
                <p>Jede Familie zahlt eine Pauschale von 6 &euro; für das MS-Office-Paket pro Schuljahr und von 4,50€ für den Jahresbericht. Dieser Betrag wird im Rahmen der Schulbuchleihe beim jüngsten Geschwisterkind, das sich aktuell an der Schule befindet, erhoben.</p>

                <div class="form-group">
                    <label for="buchleihe-pauschale">Geschwisterkinder an der Schule</label>
                    <select class="buchleihe-pauschale" name="pauschale">
                        <option></option>
                        <option value="6">Ich bin das j&uuml;ngste oder einzige Kind meiner Familie an der Ursulaschule</option>
                        <option value="0">Ich habe j&uuml;ngere Geschwisterkinder an der Schule</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

@if ( Auth::user()->istAdmin() )
<div class="row">
    <div class="col-md-6">
        <div class="box box-solid box-default">
            <div class="box-header">
                <h3 class="box-title">Welchen aktuelle Jahrgang soll ausgewählt werden?</h3>
                <div class="box-tools pull-right">
                    <span class="label label-danger">Admin</span>
                </div>
            </div>
            <div class="box-body">
                 <div class="form-group">
                    <label for="buchleihe-jahrgang">Jahrgang</label>
                    <select class="buchleihe-jahrgang" name="jahrgang">
                        <option @if ($jahrgang==4)  selected @endif value="4">04</option>
                        <option @if ($jahrgang==5)  selected @endif value="5">05</option>
                        <option @if ($jahrgang==6)  selected @endif value="6">06</option>
                        <option @if ($jahrgang==7)  selected @endif value="7">07</option>
                        <option @if ($jahrgang==8)  selected @endif value="8">08</option>
                        <option @if ($jahrgang==9) selected @endif value="9">09</option>
                        <option @if ($jahrgang==10) selected @endif value="10">10</option>
                        <option @if ($jahrgang==11) selected @endif value="11">11</option>
                        <option @if ($jahrgang==20) selected @endif value="20">20</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<div>
    <button type="submit" class="btn btn-primary">Weiter</button>
</div>

</form>

@stop

@section('js')
<script>
    $(document).ready(function() {
        $('.buchleihe-ermaessigung').select2({
            placeholder: 'Bitte auswählen',
            minimumResultsForSearch: -1,
            width: '100%' // need to override the changed default
        });
        $('.buchleihe-pauschale').select2({
            placeholder: 'Bitte auswählen',
            minimumResultsForSearch: -1,
            width: '100%' // need to override the changed default
        });
         $('.buchleihe-jahrgang').select2({
            minimumResultsForSearch: -1,
            width: 'style' // need to override the changed default
        });
    }); 
</script>
@stop