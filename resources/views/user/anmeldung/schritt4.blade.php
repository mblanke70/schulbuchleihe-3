@extends('layouts.home')

@section('title', 'Anmeldung zur Buchausleihe im Schuljahr 2019/20')

@section('heading')
    <h4>Anmeldung (Schritt 4/4)</h4>
    <h4>{{ Auth::user()->vorname }} {{ Auth::user()->nachname }} ({{ Auth::user()->klasse }})</h4> 
@endsection

@section('content')
	
	@if ($errors->any())
	    <div class="alert alert-danger">
	        {{ $errors->first() }}
	    </div>
	@endif

   
    <form action="{{ url('user/anmeldung/schritt4') }}" method="POST" role="form">

    {{ csrf_field() }}
    
    <h3>Bankeinzugsverfahren</h3>

    <p>Die Summe der Leihgebühren beträgt:</p>
           
    <h4 style="text-align: center;">{{ number_format($summeLeihenReduziert, 2, ',', '') }} &euro;

        @switch($ermaessigung)          
            @case(2)
                (Ermäßigung 100%) 
                @break
            
            @case(1)
                (Ermäßigung 20%) 
                @break

            @case(0)
                (keine Ermäßigung)
        @endswitch
    </h4>

    <p>Dieser Gesamtbetrag wird in diesem Jahr per Bankeinzug von dem Konto eingezogen, von dem auch vierteljährlich das Schulgeld für Ihr Kind eingezogen wird. Dafür benötigen wir eine Einverständniserklärung, die nur einmalig gilt und in jedem Jahr erneuert werden muss. Wir belasten den Betrag dem Konto, von dem auch das Schulgeld eingezogen wird.</p>
    
    <p>Nach Abschluss des Leihverfahrens bleiben die Listen der gewählten Leih- und Kaufbücher weiterhin hier einsehbar.</p>

    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" id="buchleihe-zustimmung" name="zustimmung">
        <label class="custom-control-label" for="buchleihe-zustimmung">
            Ich bin damit einverstanden, dass der Gesamtbetrag in Höhe von {{ number_format($summeLeihenReduziert, 2, ',', '') }}&nbsp;&euro; für das Schuljahr 2019/20 von dem Konto eingezogen wird, von dem auch das Schulgeld für mein Kind eingezogen wird.
        </label>
        <input type="hidden" name="betrag" value="{{ $summeLeihenReduziert }}" />
    </div>
        
    <div class="mt-4">
        <button type="submit" class="btn btn-danger">Zustimmen</button>
    </div>

    </form>

    <hr/>

    <h3>Leihbücher</h3>
    
    <table class="table table-striped"">
        <thead>
            <tr>
                <th>Titel</th> 
                <th>ISBN</th>
                <th>Verlag</th>
                <th>Leihgebühr</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($leihliste as $bt)
                <tr>
                    <td scope="row">{{ $bt->buchtitel->titel }}</td>
                    <td>{{ $bt->buchtitel->isbn }}</td>
                    <td>{{ $bt->buchtitel->verlag }}</td>
                    <td>{{ $bt->leihpreis }} &euro;</td>
                </tr>
            @endforeach

        </tbody>

    </table> 

    <h5>Die Summe der (nicht reduzierten) Leihpreise beträgt {{ number_format($summeLeihen, 2, ',', '') }} &euro;.</h5>

    <hr/>

    <h3>Kaufbücher</h3> 
    
    <table class="table table-striped"">
        <thead>
            <tr>
                <th>Titel</th> 
                <th>ISBN</th>
                <th>Verlag</th>
                <th>Preis</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($kaufliste as $bt)
                <tr>
                    <td scope="row">{{ $bt->buchtitel->titel }}</td>
                    <td>{{ $bt->buchtitel->isbn }}</td>
                    <td>{{ $bt->buchtitel->verlag }}</td>
                    <td>{{ $bt->kaufpreis }} &euro;</td>
                </tr>
            @endforeach

        </tbody>

    </table> 
        
    <h5>Die Summe der Kaufpreise beträgt {{ number_format($summeKaufen, 2, ',', '') }} &euro;.</h5>
    
    <p>Die hier aufgeführten Bücher kaufen Sie sich selbst. Es findet keine Sammelbestellung von Schulseite aus statt.</p>
                
@endsection