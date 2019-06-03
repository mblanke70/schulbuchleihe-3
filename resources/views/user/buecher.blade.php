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

    <!--@isset($schueler)<h4>{{ $schueler->id }}</h4>@endisset-->

    @if(!empty($buecher))
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
            @foreach ($buecher as $buch)
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
    @else
    <p>Keine Bücher ausgeliehen.</p>
    @endif

@endsection