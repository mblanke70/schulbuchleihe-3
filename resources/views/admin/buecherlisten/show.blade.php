@extends('adminlte::page')

@section('title', 'Bücherlisten')

@section('content_header')
    <h1>Bücherliste</h1>
@stop

@section('content')

<div class="row">

    <div class="col-md-6">
        <div class="box">

            <div class="box-header with-border">
                <h3 class="box-title">Bücherliste</h3>
            </div>

            <table class="table">
                <tr>
                    <th>ID</th>
                    <td>{{ $buecherliste->id }}</td>
                <tr>
                    <th>Jahrgang</th>
                    <td>{{ $buecherliste->jahrgang }}</td>
                </tr>
                <tr>
                    <th>Schuljahr</th>
                    <td>{{ $buecherliste->schuljahr }}</td>
                </tr>

            </table>

        </div>
    </div>

    <div class="col-md-6">
        <div class="box">

            <div class="box-header with-border">
                <h3 class="box-title">Buchtitel hinzufügen</h3>
            </div> 

            <form action="{{ url('admin/buecherlisten/attach', [$buecherliste->id]) }}" method="POST">
            
            {{ csrf_field() }}

            <div class="box-body">

                <div class="form-group">
                    <label for="buchtitel-titel">Buchtitel auswählen</label>

                    <select name="bid" class="form-control" id="buchtitel-titel"> 
                    @foreach ($booktitlesNotAttached as $bt)
                        <option value="{{ $bt->id }}">{{ $bt->titel }}</option>
                    @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="buchtitel-buchgruppe">Buchgruppe</label>

                    <select name="buchgruppe" class="form-control" id="buchtitel-buchgruppe">
                        <option value="">keine</option>
                    @foreach ($buchgruppen as $bg)
                        <option value="{{ $bg->id }}">{{ $bg->fach->name }} {{ $bg->bezeichnung }}</option>
                    @endforeach
                    </select>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="ausleihbar" value="1" id="buchtitel-ausleihbar" checked>
                    <label class="form-check-label" for="buchtitel-ausleihbar">Ausleihe möglich?</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="verlaengerbar" value="1" id="buchtitel-verlaengerbar">
                    <label class="form-check-label" for="buchtitel-verlaengerbar">Verlängerung möglich?</label>
                </div>

                 
            </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-primary">Hinzufügen</button>
            </div>

            </form>

        </div>
    </div>

</div>

    <hr />

<div class="box">    

    <div class="box-header with-border">
        <h3 class="box-title">Buchtitel</h3>
    </div> 
    
    <div class="box-body">  
        <table id="buchtitel" class="table table-striped"">
            <thead>
                <tr>
                    <th scope="row">ID</th>
                    <th>Kennung</th>
                    <th>Fach</th>
                    <th>Titel</th> 
                    <th>ISBN</th>
                    <th>Verlag</th>
                    <th>Ausl.?</th>
                    <th>Verl.?</th>
                    <th>Buchgruppe</th>
                    <th>Preis</th>
                    <th>Leihgeb.</th>
                </tr>
            </thead>

            <tbody>

            @foreach ($booktitlesAttached as $bt)

                <tr>
                    <td scope="row">{{ $bt->id }}</td>
                    <td>{{ $bt->kennung }}</td>
                    <td>{{ $bt->fach }}</td>
                    <td>{{ $bt->titel }}</td>
                    <td>{{ $bt->isbn }}</td>
                    <td>{{ $bt->verlag }}</td>
                    <td>{{ $bt->pivot->ausleihbar }}</td>
                    <td>{{ $bt->pivot->verlaengerbar }}</td>
                    <td>{{ $bt->pivot->buchgruppe }}</td>
                    <td>{{ $bt->preis }}</td>
                    <td>{{ $bt->leihgebuehr }}</td>
                    <td>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $bt->id }}').submit();">
                            <i class="fa fa-fw fa-trash"></i>
                        </a>
                               
                        <form id="delete-form-{{ $bt->id }}" action="{{ url('admin/buecherlisten/detach', [$buecherliste->id, $bt->id]) }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                        </form>
                    </td>
                </tr>

            @endforeach

            </tbody>

        </table>

    </div>
</div>

@endsection