@extends('layouts.sport')

@section('title', 'Sportwahlen')

@section('heading')
    <h3 class="mt-3">Sportwahl für die Jahrgangsstufen 12 und 13: <strong>{{ $user->name }}</strong></h3>
@endsection

@section('content')

    @if ($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
    @endif
    
    <h5>Gewählt am: {{ $sportwahl->updated_at }}</h5>

    <h4 class="mt-4">Gewählte Kurse</h4>
    <ul>
        <li>12/1: <strong>{{ $sportwahl->sem1 }}</strong> </li>
        <li>12/2: <strong>{{ $sportwahl->sem2 }}</strong> </li>
        <li>13/1: <strong>{{ $sportwahl->sem3 }}</strong> </li>
        <li>13/2: <strong>{{ $sportwahl->sem4 }}</strong> </li>
    </ul>

    <h4 class="mt-4">Ersatzwahlen</h4>
    <ul>
        <li>Bewegungsfeld A: <strong>{{ $sportwahl->subA }}</strong> </li>
        <li>Bewegungsfeld B: <strong>{{ $sportwahl->subB }}</strong> </li>
    </ul>

    <p>Eine Neuwahl ist bis zum 12.5.2019, 20 Uhr, möglich.</p>

    <a href="{{ url('user/sportwahlen/wahlbogen') }}"><button type="button" class="btn btn-primary">Neuwahl</button></a>

@endsection