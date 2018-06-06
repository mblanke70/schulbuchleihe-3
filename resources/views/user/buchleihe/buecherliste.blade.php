@extends('adminlte::page')

@section('title', 'Bücherliste')

@section('content_header')
    <h1>Leihverfahren: Bücherauswahl (Schritt 3)</h1>
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

<form action="{{ url('user/buchleihe/buecherwahlen') }}" method="POST" role="form">

    {{ csrf_field() }}
            
    <div class="box box-primary box-solid">

        <div class="box-header with-border">
            <h3 class="box-title">Buchtitel</h3>
        </div> 
 
        <div class="box-body">  

            <table id="buchtitel" class="table table-striped"">
                <thead>
                    <tr>
                        <th>Titel</th> 
                        <th>ISBN</th>
                        <th>Verlag</th>
                        <th>Preis</th>
                        <th>Leihgeb.</th>
                        <th>Leihen</th>
                        <th>Verlängern</th>
                        <th>Kaufen</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($buecherliste as $bt)
                        <tr>
                            <td scope="row">{{ $bt->titel }}</td>
                            <td>{{ $bt->isbn }}</td>
                            <td>{{ $bt->verlag }}</td>
                            <td>{{ $bt->preis }}</td>
                            <td>{{ $bt->leihgebuehr }}</td>
                            <td>
                                @if( $bt->pivot->ausleihbar == 1 
                                    && $bt->pivot->verlaengerbar == 0)
                                    <input type="radio" value="1" name="wahlen[{{ $bt->id }}]" />
                                @endif
                            </td>
                            <td>
                                @if( $bt->pivot->verlaengerbar == 1)
                                    <input type="radio" value="2" name="wahlen[{{ $bt->id }}]" />
                                @endif
                            </td>
                            <td>
                                @if( $bt->pivot->ausleihbar == 1)
                                    <input type="radio" value="0" name="wahlen[{{ $bt->id }}]" />
                                    <input type="radio" value="" name="wahlen[{{ $bt->id}}]" checked style="display: none"/>
                                @else
                                    <input type="radio" value="0" name="wahlen[{{ $bt->id }}]" checked />
                                @endif
                            </td>
                        </tr>
                    @endforeach

                </tbody>

            </table>           

        </div>

    </div>

    <div>
        <button type="submit" class="btn btn-primary">Weiter</button>
    </div>

</form>

@stop