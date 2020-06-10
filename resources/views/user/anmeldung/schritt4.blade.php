@extends('layouts.home')

@section('title', 'Anmeldung zur Buchausleihe im Schuljahr 2020/21')

@section('heading')
    <h4>Anmeldung (Schritt 4/5)</h4>
    <h4>{{ Auth::user()->vorname }} {{ Auth::user()->nachname }} ({{ Auth::user()->klasse }})</h4> 
@endsection

@section('content')
	
	@if ($errors->any())
	    <div class="alert alert-danger">
	        {{ $errors->first() }}
	    </div>
	@endif

    <h4 class="box-title">E-Books</h4>
    
    <p>Für viele Bücher besteht im neuen Schuljahr die Möglichkeit, zusätzlich zum gedruckten Buch auch das digitale Schulbuch zu leihen. Wird diese Option „Print plus“ gewählt, so erhöht sich der Leihpreis des Buches um 1,00 €. Damit erhält man den Zugang zum E-Book über die jeweilige App der Lehrmittelverlage. (Ein E-Book ohne gedrucktes Buch ist über unsere Schulbuchleihe nicht erhältlich. Dies geht nur beim Verlag zu deutlich höheren E-Book-Preisen.)</p>

    <p>In dieser Übersicht sehen Sie, ob für Ihre Buchauswahl eine "Print Plus"-Option verfügbar ist. Geben Sie an, welche Bücher Sie auch als E-Book bestellen möchten.</p>
   
    <form action="{{ url('user/anmeldung/schritt4') }}" method="POST" role="form">

    {{ csrf_field() }}
    
        
        <table class="table table-striped"">
            <thead>
                <tr>
                    <th>Ebook</th>
                    <th>Preis</th>
                    <th>Titel</th> 
                    <th>Fach</th>
                    <th>ISBN</th>
                    <th>Verlag</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($leihliste as $bt)
                    <tr>
                        <td>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="ebook-{{ $bt->id }}" name="ebooks[]" value="{{ $bt->id }}" >
                                <label class="custom-control-label" for="ebook-{{ $bt->id }}"></label>
                            </div>
                        </td>
                        <td>{{ $bt->ebook }} &euro;</td>
                        <td>{{ $bt->buchtitel->titel }}</td>
                        <td>{{ $bt->buchtitel->fach->code }}</td>
                        <td>{{ $bt->buchtitel->isbn }}</td>
                        <td>{{ $bt->buchtitel->verlag }}</td>
                    </tr>
                @endforeach

            </tbody>

        </table> 

        <div>
            <button type="submit" class="btn btn-primary">Weiter</button>
        </div>

    </form>




@endsection