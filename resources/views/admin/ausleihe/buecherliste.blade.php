@extends('adminlte::page')

@section('title')
{{ $user->nachname }} , {{ $user->vorname }} ({{ $user->klasse }})
@stop

@section('content_header')
    <h1>Bücherliste: {{ $user->nachname }} , {{ $user->vorname }} ({{ $user->klasse }})</h1>
@stop

@section('content')

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
                            <th>ausgeliehen?</th>
                            <th>Fach</th> 
                            <th>Titel</th>
                            <th>Bestellstatus</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($buchtitel->sortBy('wahl') as $bt)
                        <tr>                                    
                            <td>
                            @if ($bt->ausgeliehen) ja @endif 
                            </td>
                            <td>{{ $bt->fach->code }}</td>
                            <td>{{ $bt->titel }}</td>
                            <td>  
                                @if($bt->wahl==1)  
                                    leihen
                                @elseif($bt->wahl==2)
                                	verlängern
                                @elseif($bt->wahl==3)
                                	kaufen
                                @else($bt->wahl==4)
                                    nicht gewählt
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>            

    </div>

@stop

@section('js')

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
    
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>

    <script>

    	 $(document).ready(function() {

            $('#buecherliste').DataTable({
                "searching": false, 
                "info": false, 
                "paging": false,     
                "order": [],   
                "dom": 'Bfrtip',   
                "buttons": [
                    {
                        extend: 'print',
                        customize: function ( win ) {
                            $(win.document.body)
                                .css( 'font-size', '12pt' );
         
                            $(win.document.body).find( 'table' )
                                .addClass( 'compact' )
                                .css( 'font-size', 'inherit' );
                        }, 
                        exportOptions: {
                            columns: [ 0, 1, 2, 3 ]
                        }
                    }
                ],    
            });

        });

    </script>

@stop