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

            <!--
            <div class="box box-solid box-warning">   
                <div class="box-header with-border">
                    <div class="box-title">
                        Ausgewählte Bücher
                    </div>
                </div>

                <div class="box-body">

                    @if(isset($auswahlbuecher))
                        <ul>
                            @foreach($auswahlbuecher as $key => $value) 
                            
                            <li>
                                @if($value) 
                                    {{ $value->buchtitel->fach->code }}: {{ $value->buchtitel->titel }} ({{$value->buchtitel->verlag }})
                                @endif

                                <a href="#" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $key }}').submit();">
                                    <i class="fa fa-fw fa-trash"></i>
                                </a>

                                <form id="delete-form-{{ $key }}" action="{{ url('admin/ausleihe/'.$klasse->id.'/'.$user->id.'/auswahl') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <input type="hidden" name="buch_id" value="{{ $value->id }}" />
                                </form>
                                
                            </li>

                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="box-footer">
                    <form action="{{ url('admin/ausleihe/'.$klasse->id.'/'.$user->id) }}" method="POST">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-warning">Übernehmen</button>
                    </form>
                </div>
            </div>
            -->

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

                        <table id="leihen" class="display compact" cellspacing="0" width="100%">

                            <thead>
                                <tr>
                                    <th>Leihstatus</th>
                                    <th>Löschen</th>
                                    <th>Fach</th> 
                                    <th>Titel</th>
                                    <th>Wahl</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach ($buchwahlen as $b)

                                    <tr>
                                        <td>
                                        @if ($b->leihstatus == 1)
                                            <i class="fa fa-check-square fa-lg"></i>
                                        @endif 
                                        </td>
                                        <td>
                                        @if ($b->leihstatus == 1)
                                            <a href="#" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $b->buchtitel->id }}').submit();">
                                                <i class="fa fa-fw fa-trash"></i>
                                            </a>

                                            <form id="delete-form-{{ $b->buchtitel->id }}" action="{{ url('admin/ausleihe/'.$klasse->id.'/'.$user->id) }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <input type="hidden" name="buch_id" value="{{ $b->buch_id }}" />
                                            </form>
                                        @endif
                                        </td>
                                        <td>{{ $b->buchtitel->fach->code }}</td>
                                        <td>{{ $b->buchtitel->titel }}</td>
                                        <td>
                                            @if($b->wahl==1)
                                                Leihen
                                            @else
                                                Verlängern
                                            @endif
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
            $('#buecher, #leihen, #verlaengern').DataTable({
                searching: false, 
                info: false, 
                paging: false,
                order: [[ 4, "desc" ]],
                language: {
                    "emptyTable": "Keine Bücher ausgeliehen."
                }
            });
            $("#buch").focus();
        } );
    </script>
@stop