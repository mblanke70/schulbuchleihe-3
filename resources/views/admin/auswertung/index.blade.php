@extends('adminlte::page')

@section('title', 'Buchtitel')

@section('content_header')
    <h1>Buchtitel</h1>
@stop

@section('content')


<div class="box-body">

    <table id="auswertung" class="display" cellspacing="0" width="100%">

        <thead>

            <tr>
                <th>ID</th>
                <th>Kennung</th>
                <th>ISBN</th>
                <th>Titel</th>
                <th>Verlag</th>
                <th>Bestand</th>
                <th>Ausgeliehen</th>
                <th>Preis</th>
                <th>Leihgebühr</th>
            </tr>

        </thead>

        <tfoot>

            <tr>
                <th>ID</th>
                <th>Kennung</th>
                <th>ISBN</th>
                <th>Titel</th>
                <th>Verlag</th>
                <th>Bestand</th>
                <th>Ausgeliehen</th>
                <th>Preis</th>
                <th>Leihgebühr</th>
            </tr>

        </tfoot>

        <tbody>

            @foreach ($buchtitel as $t)
            
                <tr>
                    <td> {{ $t->id }} </td>
                    <td> {{ $t->kennung }} </td>
                    <td> {{ $t->isbn }} </td>
                    <td>
                        <a href="{{ url('buchtitel/'.$t->id) }}"> {{ $t->titel }} </a>
                    </td>
                    <td> {{ $t->verlag }} </td>
                    <td>
                        @if($t->buecher()) 
                            {{ $t->buecher()->count() }}
                        @endif
                    </td>
                    <td>
                        @if($t->ausgelieheneBuecher()) 
                            {{ $t->ausgelieheneBuecher()->count() }}
                        @endif
                    </td>
                    <td> {{ $t->preis }} </td>
                    <td> {{ $t->leihgebuehr }} </td>

                </tr>

            @endforeach

        </tbody>

    </table>

</div>

@stop

@section('js')
    <script>
        $(document).ready(function() {
            var table = $('#auswertung').DataTable( {
                rowReorder: true,
                stateSave: true
            } );
        } );
    </script>
@stop