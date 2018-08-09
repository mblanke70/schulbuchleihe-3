@extends('adminlte::page')

@section('title', 'Ausleihe')

@section('content_header')
    <h1>Ausleihe für {{ $user->nachname }}, {{ $user->vorname }} ({{ $klasse->bezeichnung }}) 
        @if($user->ermaessigung && $user->ermaessigung < 10)
          {{ (10-$user->ermaessigung)*10 }}% 
        @endif
    </h1>
@stop

@section('content')

    <div class="row">
        
        <div class="col-md-5">

            <div class="box box-solid">
                <div class="box-body">
                    <div class="btn-group" role="group">
                        <a class="btn btn-primary" href="{{ url('admin/ausleihe/'.$klasse->id) }}" role="button">
                            <i class="fa fa-chevron-circle-up fa-lg"></i>
                        </a>

                        @if($prev!=null)
                        <a class="btn btn-primary" href="{{ url('admin/ausleihe/'.$klasse->id.'/'.$prev->id) }}" role="button">
                            <i class="fa fa-chevron-circle-left fa-lg"></i>
                        </a>
                        @endif

                        @if($next!=null)
                        <a class="btn btn-primary" href="{{ url('admin/ausleihe/'.$klasse->id.'/'.$next->id) }}" role="button"> 
                            <i class="fa fa-chevron-circle-right fa-lg"></i> 
                        </a>
                        @endif    
                    </div>
                </div>
            </div>

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

            <div class="box box-solid box-warning">   
                <div class="box-header with-border">
                    <div class="box-title">
                        Ausgeliehene Bücher
                    </div>
                    <div class="box-tools pull-right">
                      
                    </div>
                </div>

                <div class="box-body">
                    Ermäßigungsstatus (bestätigt):
                    <form class="form-inline" action="{{ url('admin/ausleihe/ermaessigungen/'.$klasse->id.'/'.$user->id) }}" method="POST">
                        {{ csrf_field() }}   

                        <select class="buchleihe-ermaessigung" name="ermaessigung">
                            <option value="">unbestätigt</option>
                            <option value="10" @if($user->bestaetigt==10) selected @endif>keine</option>
                            <option value="8" @if($user->bestaetigt==8) selected @endif>20%</option>
                            <option value="0" @if($user->bestaetigt===0) selected @endif>100%</option>
                        </select>
                    </form>

                    <div class="table-responsive">
                        <table id="buecher" class="display compact" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="7%">Fach</th> 
                                    <th width="13%">ID</th> 
                                    <th width="60%">Titel</th>
                                    <th width="">Leihgebühr</th>
                                    <th width="10%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($buecher as $b)
                                <tr>
                                    <td>{{ $b->buchtitel->fach->code }}</td>
                                    <td>{{ $b->id }}</td>
                                    <td>{{ $b->buchtitel->titel }}</td>
                                    <td>{{ $b->buchtitel->leihgebuehr }}</td>
                                    <td>
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
     
        <div class="col-md-7">

            <div class="box box-solid box-success">   
                <div class="box-header with-border">
                    <div class="box-title">
                        Bücherliste
                    </div>
                </div>

                <div class="box-body">
                    <div class="table-responsive">

                    <form action="{{ url('admin/ausleihe/'.$klasse->id.'/'.$user->id) }}" method="POST" >

                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

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
                                        <select name="wahlen[{{$bt->id}}]">

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

                    </form>

                    </div>
                </div>            
            </div>
        </div>
    </div>

    <div id="modal-confirm" class="modal modal-warning fade">   
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Schließen">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Achtung!</h4>
                </div>
                <div class="modal-body">
                    <ul>
                    @foreach($errors->get('buch_id') as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                    </ul>
                    <p>Soll das Buch trotzdem ausgeliehen werden?</p>
                </div>
                <div class="modal-footer">
                    <form action="{{ url('admin/ausleihe/'.$klasse->id.'/'.$user->id) }}" method="POST">
                        {{ csrf_field() }}       
                        <input type="hidden" name="confirmed" value="1" />
                        <input type="hidden" name="buch_id" value="{{ old('buch_id') }}" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
                        <button type="submit" class="btn btn-warning"><i class="fa fa-times-circle"></i> Speichern</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-warning" class="modal modal-danger fade">   
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Schließen">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Achtung!</h4>
                </div>
                <div class="modal-body">
                    <ul>
                    @foreach($errors->get('buch_id') as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Abbrechen</button>
                </div>
            </div>
        </div>
    </div>

@stop

@section('js')
    <script>

        @if($errors->any())
            @if($errors->first('type') == 'confirm')
                $(function() { $('#modal-confirm').modal(); });
            @elseif($errors->first('type') == 'warning')
                $(function() { $('#modal-warning').modal(); });
            @endif
        @endif
        
        $(document).ready(function() {
            /*
            $('#modal-warning').on('show.bs.modal', function(e) {
                var url = $(e.relatedTarget).data('url');
                $(e.currentTarget).find('form').attr('action', url);
            });
            */

            $('form select').on('change', function(){
                $(this).closest('form').submit();
            });

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