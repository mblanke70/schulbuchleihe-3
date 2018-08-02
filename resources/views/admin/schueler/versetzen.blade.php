@extends('adminlte::page')

@section('title', 'Schüler')

@section('content_header')
    <h1>Schüler versetzen</h1>
@stop

@section('content')

<div class="box box-primary">

    <div class="box-header with-border">
        <h3 class="box-title">Schüler versetzen</h3>
    </div>
    
    <form action="{{ url('admin/versetzenSpeichern') }}" method="POST" role="form">

        {{ csrf_field() }}

        <div class="box-body">
    
            <div class="form-group">
                <label for="schueler-klasse">Klasse</label>
                <select id="schueler-klasse" class="schueler-klasse" name="klasse">
                    <option></option>
                    @foreach($klassen as $klasse)
                        <option value="{{ $klasse->bezeichnung }}">{{ $klasse->bezeichnung }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="schueler-zielklasse">Zielklasse</label>
                <select id="schueler-zielklasse" class="schueler-zielklasse" name="zielklasse">
                    <option></option>
                    @foreach($klassen as $klasse)
                        <option value="{{ $klasse->bezeichnung }}">{{ $klasse->bezeichnung }}</option>
                    @endforeach
                </select>
            </div>

        </div>
        
        <div class="box-footer">
            <button type="submit" class="btn btn-primary">Speichern</button>
        </div>
    </form>

</div>

@stop

@section('js')
<script>
    $(document).ready(function() {
        $('.schueler-klasse').select2({
            placeholder: 'Bitte auswählen',
            minimumResultsForSearch: -1,
            width: '100%' // need to override the changed default
        });

        $('.schueler-zielklasse').select2({
            placeholder: 'Bitte auswählen',
            minimumResultsForSearch: -1,
            width: '100%' // need to override the changed default
        });
    }); 
</script>
@stop