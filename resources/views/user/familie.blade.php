@extends('layouts.home')

@section('title', 'Schulbuchleihe - Ursulaschule Osnabrück')

@section('heading')
   	<h4>Familie {{ $user->nachname }}</h4>
    <h4>{{ $user->vorname }} {{ $user->nachname }} ({{ $user->klasse }})</h4> 
@endsection

@section('content')

    <h4>Geschwisterkinder an der Ursulaschule</h4>

	<table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th> 
                <th>Vorname</th>
                <th>Klasse</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($familie->users as $u)
                <tr>
                    <td scope="row">{{ $u->nachname }}</td>
                    <td>{{ $u->vorname }}</td>
                    <td>{{ $u->schuelerInSchuljahr(4)->first()->klasse->bezeichnung }}</td>
                </tr>
            @endforeach
        </tbody>

    </table>

    <br />

    <h4>Externe Geschwisterkinder</h4>

    <form action="{{ url('user/uploads/'.$familie->id) }}" method="POST" role="form" enctype="multipart/form-data">

        @csrf

         <div class="row">
            <div class="col-md-6">

                <div>
                    <label for="vorname">Vorname</label>
                    <input type="text" name="vorname" class="form-control">
                </div>

                <div>
                    <label for="gebdatum">Geburtsdatum</label>
                    <input type="date" name="gebdatum" class="form-control">
                </div>

                <div class="custom-file">
                    <label class="custom-file-label" for="datei">Datei auswählen</label>
                    <input type="file" name="file" class="custom-file-input" id="datei">
                </div>

                <button type="submit" class="btn btn-success">Upload</button>
            </div>
           
        </div>

    </form> 

@endsection