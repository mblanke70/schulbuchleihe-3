@extends('adminlte::page')

@section('title', 'Leihverfahren')

@section('content_header')
    <h1>Leihverfahren: Bücherauswahl (Schritt 3/4)</h1>
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

<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: 50%; background-color: #444;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%</div>
</div>

<form action="{{ url('user/buchleihe/buecherliste') }}" method="POST" role="form">

    {{ csrf_field() }}
            
    <div class="box box-primary box-solid">

        <div class="box-header with-border">
            <h3 class="box-title">Buchtitel</h3>
        </div> 

            <div class="box-body">  

            <div class="table-responsive">
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
                                    <input type="radio" value="" name="wahlen[{{ $bt->id }}]" style="display: none;" checked/>
                                    
                                    @if( $bt->pivot->ausleihbar == 1 )
                                        <input type="radio" value="1" name="wahlen[{{ $bt->id }}]" @if (old('wahlen.'.$bt->id) == 1) checked @endif />
                                    @endif
                                </td>
                                <td>
                                    @if( $bt->pivot->verlaengerbar == 1)
                                        <input type="radio" value="2" name="wahlen[{{ $bt->id }}]" @if (old('wahlen.'.$bt->id) == 2) checked @endif/>
                                    @endif
                                </td>
                                <td>
                                    @if( $bt->preis > 0)

                                        @if( $bt->pivot->ausleihbar == 1)
                                            <input type="radio" value="3" name="wahlen[{{ $bt->id }}]" @if (old('wahlen.'.$bt->id) == 3) checked @endif/>
                                        @else
                                            <input type="radio" value="3" name="wahlen[{{ $bt->id }}]" checked />
                                        @endif

                                    @endif
                                </td>
                            </tr>
                        @endforeach

                    </tbody>

                </table>           

            </div>
            
        </div>

    </div>

    <div>
        <button type="submit" class="btn btn-primary">Weiter</button>
    </div>

</form>

@stop