@extends('adminlte::page')

@section('title')
{{ $schueler->nachname }} , {{ $schueler->vorname }} ( {{ $schueler->klasse->bezeichnung }})
@stop

@section('content_header')
    <h1>Ausleihe für {{ $schueler->nachname }}, {{ $schueler->vorname }}</a> ({{ $schueler->klasse->bezeichnung }}) 
    </h1>
@stop

@section('content')

    <div class="row">
        
        <div class="col-md-5">

            <div class="box box-solid">
                <div class="box-body">
                    <div class="btn-group" role="group">
                        <a class="btn btn-primary" href="{{ url('admin/ausleihe/'.$schueler->klasse_id) }}" role="button">
                            <i class="fa fa-chevron-circle-up fa-lg"></i>
                        </a>

                        @if($prev!=null)
                        <a class="btn btn-primary" href="{{ url('admin/ausleihe/'.$schueler->klasse_id.'/'.$prev->id) }}" role="button">
                            <i class="fa fa-chevron-circle-left fa-lg"></i>
                        </a>
                        @endif

                        @if($next!=null)
                        <a class="btn btn-primary" href="{{ url('admin/ausleihe/'.$schueler->klasse_id.'/'.$next->id) }}" role="button"> 
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
                            <form action="{{ url('admin/ausleihe/'.$schueler->klasse_id.'/'.$schueler->id) }}" method="POST" >                
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

                    <div class="table-responsive">
                        <table id="buecher" class="display compact" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="7%">Fach</th> 
                                    <th width="13%">ID</th> 
                                    <th width="60%">Titel</th>
                                    <th width="10%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($buecher as $b)
                                <tr>
                                    <td>{{ $b->buchtitel->fach->code }}</td>
                                    <td>{{ $b->id }}</td>
                                    <td>{{ $b->buchtitel->titel }}</td>
                                    <td>
                                        <a href="#" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $b->id }}').submit();">
                                            <i class="fa fa-fw fa-trash"></i>
                                        </a>

                                        <form id="delete-form-{{ $b->id }}" action="{{ url('admin/ausleihe/'.$schueler->klasse_id.'/'.$schueler->id) }}" method="POST" style="display: none;">
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

<!--
                    <div class="box-footer">
                        Die Leihgebühr beträgt {{ number_format($summe, 2, ',', '') }} &euro;.
                        <br />
                        @if($schueler->erm_bestaetigt>0)
                            Die ermäßigte Leihgebühr beträgt {{ number_format($summeErm, 2, ',', '') }} &euro;.
                        @endif
                    </div>
-->
                    <!-- box-footer -->
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

                    <form action="{{ url('admin/ausleihe/'.$schueler->klasse_id.'/'.$schueler->id) }}" method="POST" >

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

                            @for ($i = 1; $i <= 4; $i++)

                                @foreach ($buchtitel->where('wahl', $i) as $btsj)

                                <tr>                                    
                                    <td>
                                    @if ($btsj->ausgeliehen == 1)
                                        <i class="fa fa-check-square fa-lg"></i>
                                    @endif 
                                    </td>
                                    <td>{{ $btsj->buchtitel->fach->code }}</td>
                                    <td>{{ $btsj->buchtitel->titel }}</td>
                                    <td>  
                                        <select name="wahlen[{{$btsj->id}}]">

                                            {{-- @if( $btsj->leihpreis > 0) --}}
                                                <option value="1" 
                                                    @if($btsj->wahl==1) selected @endif 
                                                />leihen</option>

                                                <option value="2" 
                                                    @if($btsj->wahl==2) selected @endif 
                                                />verlängern</option>
                                            {{-- @endif --}}

                                            {{-- @if( $btsj->preis > 0) --}}
                                                <option value="3" 
                                                    @if($btsj->wahl==3) selected @endif 
                                                />kaufen</option>
                                            {{-- @endif --}}

                                            <option value="4" 
                                                @if($btsj->wahl==4) selected @endif 
                                            />abgewählt</option>

                                        </select>
                                    </td>
                                </tr>

                                @endforeach

                            @endfor

                            </tbody>

                        </table>

                    </form>

                    </div>
                </div>    
            </div>
        </div>
    </div>

    <div id="modal-confirm" class="modal modal-warning fade" tabindex="-1">   
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
                    <form action="{{ url('admin/ausleihe/'.$schueler->klasse_id.'/'.$schueler->id) }}" method="POST">
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

    <div id="modal-warning" class="modal modal-danger fade" tabindex="-1">   
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

            $('#modal-warning').on('hidden.bs.modal', function (e) {
                $("#buch").focus();
            });

            $('#modal-confirm').on('hidden.bs.modal', function (e) {
                $("#buch").focus();
            });
        } );
    </script>
@stop