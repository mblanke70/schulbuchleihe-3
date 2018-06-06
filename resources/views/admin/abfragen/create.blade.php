@extends('adminlte::page')

@section('title', 'Abfrage')

@section('content_header')
    <h1>Neue Abfrage</h1>
@stop

@section('content')

<div class="box box-primary">

    <div class="box-header with-border">
        <h3 class="box-title">Neue Abfrage</h3>
    </div>
    
    <form action="{{ url('admin/abfragen/') }}" method="POST" role="form">

        {{ csrf_field() }}

        <div class="box-body">

            <div class="form-group">
                <label for="abfragen-parent">Parent ID</label>
                <input type="text" class="form-control" name="parent_id" id="abfragen-parent" placeholder="Parent-ID" />
            </div>

            <div class="form-group">
                <label for="abfragen-jahrgang">Jahrgang</label>
                <input type="text" class="form-control" name="jahrgang" id="abfragen-jahrgang" placeholder="Jahrgang" />
            </div>
    
            <div class="form-group">
                <label for="abfragen-titel">Titel</label>
                <input type="text" class="form-control" name="titel" id="abfragen-titel" placeholder="Titel" />
            </div>
            
        </div>
        
        <div class="box-footer">
            <button type="submit" class="btn btn-primary">Speichern</button>
        </div>
    </form>

</div>

@stop