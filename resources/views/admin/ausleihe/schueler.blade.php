@extends('adminlte::page')

@section('title', 'Ausleihe')

@section('content_header')
    <h1>Ausleihe für {{ $user->nachname }}, {{ $user->vorname }} ({{ $klasse->bezeichnung }})</h1>
@stop

@section('content')
 
    <div class="row">
        
        <div class="col-md-4">
            <div class="box box-solid box-danger">            
                <div class="box-header with-border">                
                    <div class="box-title">
                        Buch ausleihen
                    </div>
                </div>
                <div>
                    <div class="box-body">
                        <div class="row">
                            <form action="{{ url('admin/ausleihe/'.$klasse->id.'/'.$user->id) }}" method="POST" >                
                                {{ csrf_field() }}      
                                <div class="col-md-6">
                                    <div class="form-group">   
                                        <input type="text" class="form-control" id="buch" name="buch_id" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div>
                                        <button type="submit" class="btn btn-danger">Hinzufügen</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @if ($errors->any())
            <div class="alert alert-danger">   
               {{ $errors->first('buch_id') }}</li>
            </div>
            @endif

            <div class="box box-solid box-warning">   
                <div class="box-header with-border">
                    <div class="box-title">
                        Ausgeliehene Bücher
                    </div>
                </div>

                <div class="box-body">
                    <div class="table-responsive">
                        <table class="display compact" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="15%">Fach</th> 
                                    <th width="70%">Titel</th>
                                    <th width="10%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($buecher as $b)
                                <tr>
                                    <td width="15%">{{ $b->buchtitel->fach->code }}</td>
                                    <td width="70%">{{ $b->buchtitel->titel }}</td>
                                    <td width="10%">
                                        <a href="#" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $b->id }}').submit();">
                                            <i class="fa fa-fw fa-trash"></i>
                                        </a>

                                        <form id="delete-form-{{ $b->id }}" action="{{ url('admin/ausleihe/'.$klasse->id.'/'.$user->id) }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <input type="hidden" name="buch_id" value="{{ $b->id }}" />
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
     
        <div class="col-md-8">

            <div class="box box-solid box-success">   
                <div class="box-header with-border">
                    <div class="box-title">
                        Bücherliste
                    </div>
                </div>

                <div class="box-body">
                    <div class="table-responsive">
                        <table id="buecherliste" class="display compact" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Leihstatus</th>
                                    <th>Fach</th> 
                                    <th>Titel</th>
                                    <th>Wahl</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($buchtitel->sortBy('wahl') as $bt)
                                <tr>                                    
                                    <td>
                                    @if ($bt->ausgeliehen == 1)
                                        <i class="fa fa-check-square fa-lg"></i>
                                    @endif 
                                    </td>
                                    <td>{{ $bt->fach->code }}</td>
                                    <td>{{ $bt->titel }}</td>
                                    <td>  
                                        <select name="wahlen[{{ $bt->id }}]">

                                            @if( $bt->pivot->ausleihbar == 1 )
                                                <option value="1" @if($bt->wahl==1) selected @endif /> 
                                                    leihen
                                                </option>
                                            @endif

                                            @if( $bt->pivot->verlaengerbar == 1)
                                                <option value="2" @if($bt->wahl==2) selected @endif />
                                                    verlängern
                                                </option>
                                            @endif

                                            @if( $bt->preis > 0)
                                                <option value="3" @if($bt->wahl==3) selected @endif />
                                                    kaufen
                                                </option>
                                            @endif

                                            <option value="4" @if($bt->wahl==4) selected @endif />
                                                abgewählt
                                            </option>

                                        </select>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>            
            </div>
        </div>
    </div>

    <div class="form-group">
        <form action="{{ url('admin/ausleihe/'.$klasse->id) }}" method="GET" role="form">
            <div>
                <button type="submit" class="btn btn-default">Zur Klasse</button>
            </div>

        </form>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#buecher').DataTable({
                "searching": false, 
                "info": false, 
                "paging": false,
                "language": {
                    "emptyTable": "Keine Bücher ausgeliehen."
                },
               
                    
            });

            $('#buecherliste').DataTable({
                "searching": false, 
                "info": false, 
                "paging": false,     
                "order": [],       
            });

            $('.wahl').select2({
                minimumResultsForSearch: -1,
                width: '100%' // need to override the changed default
            });

            $("#buch").focus();
        } );
    </script>
@stop