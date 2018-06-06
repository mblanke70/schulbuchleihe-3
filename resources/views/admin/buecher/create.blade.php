@extends('adminlte::page')

@section('title', 'Buchtitel')

@section('content_header')
    <h1>Neues Buch</h1>
@stop

@section('content')

<div class="box box-primary">

    <div class="box-header with-border">
        <h3 class="box-title">Neuer Buchtitel</h3>
    </div>
   
    <form action="{{ url('buecher/') }}" method="POST" role="form">

        {{ csrf_field() }}

        <div class="box-body">

            <div class="form-group">
                <label for="buecher-buchtitel">Buchtitel</label>
                <select name="buchtitel_id" class="form-control" id="buecher-buchtitel">
            
                    @foreach ($buchtitel as $bt)
                        <option value="{{ $bt->id }}">{{ $bt->titel }}</option>
                    @endforeach

                </select>
            </div>

            <div class="form-group">
                <label for="buecher-anschaffungsjahr">Anschaffungsjahr</label>
                <input type="text" class="form-control" name="anschaffungsjahr" id="buecher-anschaffungsjahr" placeholder="Anschaffungsjahr" />
            </div>
    
            <div class="form-group">
                <label for="buecher-leihgebuehr">Leihgebühr</label>
                <input type="text" class="form-control" name="leihgebuehr" id="buecher-leihgebuehr" placeholder="Leihgebühr" />
            </div>

            <div class="form-group">
                <label for="buecher-neupreis">Neupreis</label>
                <input type="text" class="form-control" name="neupreis" id="buecher-neupreis" placeholder="Neupreis" />
            </div>

        </div>
        
        <div class="box-footer">
            <button type="submit" class="btn btn-primary">Speichern</button>
        </div>
    </form>

</div>

@stop