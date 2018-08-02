@extends('adminlte::page')

@section('title', 'Leihverfahren')

@section('content_header')
    <h1>Übersicht: Leih- und Kaufbücher</h1>
    <h4>{{ Auth::user()->vorname }} {{ Auth::user()->nachname }} ({{ Auth::user()->klasse }})</h4>    
    <h4>(gewählt am: {{ $zeit }})</h4>
@stop

@section('content')

<div class="box box-solid box-success">    

    <div class="box-header">
        <h3 class="box-title">Leihbücher</h3>
    </div>
    
    <div class="box-body">  

        <table id="leihen" class="table table-striped"">
            <thead>
                <tr>
                    <th>Titel</th> 
                    <th>ISBN</th>
                    <th>Verlag</th>
                    <th>Leihgebühr</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($leihen as $bw)
                    <tr>
                        <td scope="row">{{ $bw->buchtitel->titel }}</td>
                        <td>{{ $bw->buchtitel->isbn }}</td>
                        <td>{{ $bw->buchtitel->verlag }}</td>
                        <td>{{ number_format($bw->buchtitel->leihgebuehr, 2, ',', '') }} &euro;</td>
                    </tr>
                @endforeach

            </tbody>

        </table> 

        <h4>Die Summe der Leihpreise beträgt {{ number_format($summeLeihen, 2, ',', '') }} &euro;.
        @if ($user->ermaessigung != 10)
        Die Summe der ermäßigten Leihpreise beträgt {{ $summeLeihenReduziert }} &euro;.
        @endif
        </h4>

        <h4>Zuzüglich der sonstigen Abgaben (Kopierkosten, Eltern- und SV-Arbeit
        @if ($pauschale)
            , Jahresbreicht, MS-Office-Paket
        @endif
        ) wird ein Gesamtbetrag in Höhe von {{ number_format($summeGesamt, 2, ',', '') }} &euro; abgebucht.</h4>
    </div>       

</div> 

<div class="box box-solid box-warning">    

    <div class="box-header with-border">
        <h3 class="box-title">Kaufbücher</h3>
    </div> 
    
    <div class="box-body">  

        <table id="kaufen" class="table table-striped"">
            <thead>
                <tr>
                    <th>Titel</th> 
                    <th>ISBN</th>
                    <th>Verlag</th>
                    <th>Preis</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($kaufen as $bw)
                    <tr>
                        <td scope="row">{{ $bw->buchtitel->titel }}</td>
                        <td>{{ $bw->buchtitel->isbn }}</td>
                        <td>{{ $bw->buchtitel->verlag }}</td>
                        <td>{{ number_format($bw->buchtitel->preis, 2, ',', '') }} &euro;</td>
                    </tr>
                @endforeach

            </tbody>

        </table> 
        
        <h4>Die Summe der Kaufpreise beträgt {{ number_format($summeKaufen, 2, ',', '') }} &euro;.</h4>
        <p>Die hier aufgeführten Bücher kaufen Sie sich selbst. Es findet keine Sammelbestellung von Schulseite aus statt.</p>
    </div>  

</div>

<!--
<form action="{{ url('user/buchleihe/neuwahl') }}" method="POST" role="form">
    {{ csrf_field() }}
    <div>
        <button type="submit" class="btn btn-danger">Neuwahl</button>
    </div>
</form>
-->

@stop

@section('js')

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
    
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#kaufen').DataTable( {
                dom: 'Bfrtip',   
                ordering: false,
                paging: false,
                info: false,
                searching: false,
                buttons: [
                    {
                        extend: 'print',
                        text:      '<i class="fa fa-print"></i> Liste drucken',
                        titleAttr: 'Drucken',
                        customize: function ( win ) {
                            $(win.document.body)
                                .css( 'font-size', '10pt' );
         
                            $(win.document.body).find( 'table' )
                                .addClass( 'compact' )
                                .css( 'font-size', 'inherit' );
                        }
                    }
                ],
                
            } );
        } )
    </script>
@stop