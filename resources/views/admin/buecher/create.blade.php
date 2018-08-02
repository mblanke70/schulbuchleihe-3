@extends('adminlte::page')

@section('title', 'Buchtitel')

@section('content_header')
    <h1>Neues Buch</h1>
@stop

@section('content')

<div class="box box-primary">

    <div class="box-header with-border">
        <h3 class="box-title">Neue Bücher</h3>
    </div>
   
    <form action="{{ url('admin/buecher/') }}" method="POST" role="form">

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
                <label for="buecher-anzahl">Anzahl</label>
                <input type="text" class="form-control" name="anzahl" id="buecher-anzahl" value="1" />
            </div>
    
            <div class="form-group">
                <label for="buecher-leihgebuehr">Leihpreis</label>
                <input type="text" class="form-control" name="leihgebuehr" id="buecher-leihgebuehr" placeholder="Leihpreis" />
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