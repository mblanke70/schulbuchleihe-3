@extends('adminlte::page')

@section('title', 'Buchtitel')

@section('content_header')
    <h1>Buchtitel bearbeiten</h1>
@stop

@section('content')

<div class="box box-primary">

    <div class="box-header with-border">
        <h3 class="box-title">Buchtitel bearbeiten</h3>
    </div>
    
    <form action="{{ url('buchtitel/'.$buchtitel->id) }}" method="POST" role="form">

        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <div class="box-body">

            <div class="form-group">
                <label for="buchtitel-titel">Titel</label>
                <input type="text" class="form-control" name="titel" id="buchtitel-titel" value="{{ $buchtitel->titel }}" />
            </div>

            <div class="form-group">
                <label for="buchtitel-verlag">Verlag</label>
                <input type="text" class="form-control" name="verlag" id="buchtitel-verlag" value="{{ $buchtitel->verlag }}" />
            </div>
    
            <div class="form-group">
                <label for="buchtitel-einzelpreis">Preis</label>
                <input type="text" class="form-control" name="preis" id="buchtitel-einzelpreis" value="{{ $buchtitel->preis }}" />
            </div>

            <div class="form-group">
                <label for="buchtitel-kennung">Kennung</label>
                <input type="text" class="form-control" name="kennung" id="buchtitel-kennung" value="{{ $buchtitel->kennung }}" />
            </div>

            <div class="form-group">
                <label for="buchtitel-isbn">ISBN</label>
                <input type="text" class="form-control" name="isbn" id="buchtitel-isbn" value="{{ $buchtitel->isbn }}" />
            </div>
            
        </div>
        
        <div class="box-footer">
            <button type="submit" class="btn btn-primary">Speichern</button>
        </div>
    </form>

</div>

@stop