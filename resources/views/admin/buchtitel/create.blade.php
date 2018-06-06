@extends('adminlte::page')

@section('title', 'Buchtitel')

@section('content_header')
    <h1>Neuer Buchtitel</h1>
@stop

@section('content')

<div class="box box-primary">

    <div class="box-header with-border">
        <h3 class="box-title">Neuer Buchtitel</h3>
    </div>
    
    <form action="{{ url('buchtitel/') }}" method="POST" role="form">

        {{ csrf_field() }}

        <div class="box-body">

            <div class="form-group">
                <label for="buchtitel-titel">Titel</label>
                <input type="text" class="form-control" name="titel" id="buchtitel-titel" placeholder="Titel" />
            </div>

            <div class="form-group">
                <label for="buchtitel-verlag">Verlag</label>
                <input type="text" class="form-control" name="verlag" id="buchtitel-verlag" placeholder="Verlag" />
            </div>
    
            <div class="form-group">
                <label for="buchtitel-einzelpreis">Preis</label>
                <input type="text" class="form-control" name="preis" id="buchtitel-einzelpreis" placeholder="Preis" />
            </div>

            <div class="form-group">
                <label for="buchtitel-kennung">Kennung</label>
                <input type="text" class="form-control" name="kennung" id="buchtitel-kennung" placeholder="Kennung" />
            </div>

            <div class="form-group">
                <label for="buchtitel-isbn">ISBN</label>
                <input type="text" class="form-control" name="isbn" id="buchtitel-isbn" placeholder="ISBN" />
            </div>
            
        </div>
        
        <div class="box-footer">
            <button type="submit" class="btn btn-primary">Speichern</button>
        </div>
    </form>

</div>

@stop