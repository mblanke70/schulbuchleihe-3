@extends('layouts.home')

@section('title', 'Schulbuchleihe - Ursulaschule Osnabrück')

@section('heading')
   	<h4>Ausgeliehene Bücher im Schuljahr {{ $schuljahr->schuljahr }}</h4>
    <h4>{{ Auth::user()->vorname }} {{ Auth::user()->nachname }} ({{ Auth::user()->klasse }})</h4> 
@endsection

@section('content')
	
	@if ($errors->any())
	    <div class="alert alert-danger">
	        {{ $errors->first() }}
	    </div>
	@endif
    
    @if(!empty($schueler))

        <h5>Bücher</h5>            

        @if(!empty($schueler->buecher))
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titel</th>
                        <th>Fach</th> 
                        <th>ISBN</th>
                        <th>Verlag</th>
                        <th>Ausgabedatum</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($schueler->buecher as $buch)
                        <tr>
                            <td>{{ $buch->id }}</td>
                            <td>{{ $buch->buchtitel->titel }}</td>
                            <td>{{ $buch->buchtitel->fach->name }}</td>
                            <td>{{ $buch->buchtitel->isbn }}</td>
                            <td>{{ $buch->buchtitel->verlag }}</td>
                            <td>{{ $buch->ausleiher_ausgabe }}</td>
                        </tr>
                    @endforeach
                </tbody>

            </table> 
        @endif

        @if(!empty($schueler->ebooks))

            <h5>Ebooks</h5>            

             <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titel</th>
                        <th>Fach</th>
                        <th>ISBN</th> 
                        <th>Verlag</th>
                        <th>App</th>
                        <th>Lizenzschlüssel</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($schueler->ebooks as $ebook)
                        <tr>
                            <td>{{ $ebook->id }}</td>
                            <td>{{ $ebook->buchtitel->buchtitel->titel }}</td>
                            <td>{{ $ebook->buchtitel->buchtitel->fach->code }}</td>  
                            <td>{{ $ebook->buchtitel->buchtitel->isbn }}</td>
                            <td>{{ $ebook->buchtitel->buchtitel->verlag }}</td>
                            <td>{{ $ebook->app }}</td>
                            <td>{{ $ebook->schluessel }}</td>
                        </tr>
                    @endforeach
                </tbody>

            </table> 
        @endif

    @else
        <p>Keine Bücher ausgeliehen.</p>
    @endif

@endsection