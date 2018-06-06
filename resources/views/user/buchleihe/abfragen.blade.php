@extends('adminlte::page')

@section('title', 'Ausleihverfahren 2018')

@section('content_header')
    <h1>Leihverfahren: Abfragen zu Fach- und Kursbelegungen (Schritt 2)</h1>
@stop

@section('content')

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ url('user/buchleihe/buecherliste') }}" method="GET" role="form">

    {{ csrf_field() }}

    <div class="box box-primary box-solid">

        <div class="box-header">
            <h3 class="box-title">Abfragen Jahrgang {{ Auth::user()->jahrgang }}</h3>
        </div>

        <div class="box-body">    

            @foreach ($abfragen as $abfr)

                <div class="row">
                
                    <div class="col-md-2">
                        {{ $abfr->titel }}
                    </div>
                
                    @foreach ($abfr->antworten as $antw)
                            
                    <div class="col-md-2">
            
                        <label for="antw-{{ $antw->id }}">{{ $antw->titel }}</label>

                        <input type="radio" name ="abfrage[{{ $abfr->id}}]" value="" checked style="display: none;"/>

                        @if ($abfr->child_id)
                            <!-- Abfrage für die eine Unter-Abfrage existiert -->
                            @if ($antw->wert)
                                <input type="radio" id="antw-{{ $antw->id }}" name ="abfrage[{{ $abfr->id}}]" value="{{ $antw->wert }}" onclick="show('abfr-{{ $abfr->child_id }}')"/>
                            @else
                                <input type="radio" id="antw-{{ $antw->id }}" name ="abfrage[{{ $abfr->id}}]" value="{{ $antw->wert }}" onclick="hide('abfr-{{ $abfr->child_id }}')"/>
                            @endif
                        @else
                            <!-- Abfrage ohne Unter-Abfrage -->
                            <input type="radio" id="antw-{{ $antw->id }}" name ="abfrage[{{ $abfr->id}}]" value="{{ $antw->wert }}" />
                        @endif
            
                    </div>

                    @endforeach

                </div>

            
                @if ($abfr->child_id)
                
                <div id="abfr-{{ $abfr->child_id }}" class="row" style="display:none;">

                    <div class="col-md-2"></div>
                    <div class="col-md-2">{{ $abfr->children()->first()->titel }}</div>
                        
                    @foreach ($abfr->children()->first()->antworten as $antw)

                    <div class="col-md-2">
                        <label for="antw-{{ $antw->id }}">{{ $antw->titel }}</label>
                        <input type="radio" name ="abfrage[{{ $abfr->child_id }}]" id="antw-{{ $antw->id }}"  value="{{ $antw->wert }}" />
                        <input type="radio" name ="abfrage[{{ $abfr->child_id }}]" value="" checked style="display: none;"/>
                    </div>
                        
                    @endforeach

                </div>            
                
                @endif  
                        
            @endforeach

        </div>

    </div>

    <div>
        <button type="submit" class="btn btn-primary">Weiter</button>
    </div>
        
</form>

@stop


@section('js')
<script>
    function show(id){
        $('#' + id).show();
    }
    
    function hide(id){
        $('#' + id).find('input:radio').each(function () { $(this).attr('checked', false); });
        $('#' + id).hide();
    }   
</script>
@stop