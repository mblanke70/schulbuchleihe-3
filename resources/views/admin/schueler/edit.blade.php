@extends('adminlte::page')

@section('title', 'Schüler')

@section('content_header')
    <h1>Schüler bearbeiten</h1>
@stop

@section('content')

<div class="box box-primary">

    <div class="box-header with-border">
        <h3 class="box-title">Schüler bearbeiten</h3>
    </div>
    
    <form action="{{ url('admin/schueler/'.$user->id) }}" method="POST" role="form">

        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <div class="box-body">

            <div class="form-group">
                <label for="schueler-vorname">Vorname</label>
                <input type="text" class="form-control" name="vorname" id="schueler-vorname" value="{{ $user->vorname }}" />
            </div>

            <div class="form-group">
                <label for="schueler-nachname">Nachname</label>
                <input type="text" class="form-control" name="nachname" id="schueler-nachname" value="{{ $user->nachname}}" />
            </div>
    
            <div class="form-group">
                <label for="schueler-klasse">Klasse</label>
                <select id="schueler-klasse" class="schueler-klasse" name="klasse">
                    <option></option>
                    @foreach($klassen as $klasse)
                        <option value="{{ $klasse->bezeichnung }}"
                            @if($user->klasse == $klasse->bezeichnung)
                                selected
                            @endif
                        >{{ $klasse->bezeichnung }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="schueler-iserv">IServ-ID</label>
                <input type="text" class="form-control" name="iserv_id" id="schueler-iserv" value="{{ $user->iserv_id }}"/>
            </div>

        </div>
        
        <div class="box-footer">
            <button type="submit" class="btn btn-primary">Ändern</button>
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
    }); 
</script>
@stop