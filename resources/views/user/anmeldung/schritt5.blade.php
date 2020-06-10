@extends('layouts.home')

@section('title', 'Anmeldung zur Buchausleihe im Schuljahr 2020/21')

@section('heading')
    <h4>Anmeldung (Schritt 5/5)</h4>
    <h4>{{ Auth::user()->vorname }} {{ Auth::user()->nachname }} ({{ Auth::user()->klasse }})</h4> 
@endsection

@section('content')
	
	@if ($errors->any())
	    <div class="alert alert-danger">
	        {{ $errors->first() }}
	    </div>
	@endif
   
    <form action="{{ url('user/anmeldung/schritt5') }}" method="POST" role="form">

        {{ csrf_field() }}
        
        <h5>Bankeinzugsverfahren</h5>

        <p>Die Summe der (nicht reduzierten) Leihgebühren beträgt:</p>
               
        <h4 style="text-align: center;">{{ number_format($summeLeihen, 2, ',', '') }} &euro;</h4>

        <p>Dieser Betrag wird zu Beginn des nächsten Schuljahres per Bankeinzug von dem Konto eingezogen, von dem auch vierteljährlich das Schulgeld für Ihr Kind eingezogen wird. Dafür benötigen wir Ihre Einverständniserklärung. Diese gilt nur einmalig und muss in jedem Jahr erneuert werden.</p>
        
        <p>Nach Abschluss des Leihverfahrens bleiben die Listen der gewählten Leih- und Kaufbücher weiterhin hier einsehbar.</p>

        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="buchleihe-zustimmung" name="zustimmung">
            <label class="custom-control-label" for="buchleihe-zustimmung">
                Ich bin damit einverstanden, dass die Leihgebühr für das Schuljahr 2020/21 von dem Konto eingezogen wird, von dem auch das Schulgeld für mein Kind eingezogen wird.
            </label>
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
                    <td class="text-right">{{ number_format($bt->leihpreis, 2, ',', '') }} €</td>
                    <td class="text-right">
                        @isset($ebooks)
                            @if(in_array($bt->id, $ebooks)) 
                                {{ number_format($bt->ebook, 2, ',', '') }} € 
                            @endif
                        @endisset
                    </td>
                </tr>
            @endforeach

        </tbody>

    </table> 

    <h5>Die Summe der (nicht reduzierten) Leihgebühren beträgt {{ number_format($summeLeihen, 2, ',', '') }} €.</h5>

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
                    <td>{{ number_format($bt->kaufpreis, 2, ',', '') }} €</td>
                </tr>
            @endforeach

        </tbody>

    </table> 
        
    <h5>Die Summe der Kaufpreise beträgt {{ number_format($summeKaufen, 2, ',', '') }} €.</h5>
    
    <p>Die hier aufgeführten Bücher kaufen Sie sich selbst. Es findet keine Sammelbestellung von Seiten der Schule statt.</p>
                
@endsection