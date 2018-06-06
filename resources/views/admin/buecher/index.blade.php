@extends('adminlte::page')

@section('title', 'Bücher')

@section('content_header')
    <h1>Bücher</h1>
@stop

@section('content')

<div class="box-body">
    <a class="btn btn-success" href="{{ url('buecher/create') }}">Neues Buch</a>
</div>

<div class="box-body">

    <table id="buecher" class="display" cellspacing="0" width="100%">

        <thead>
            <tr>
                <th>ID</th>
                <th>Buchtitel-Kennung</th>
                <th>Titel</th>
                <th>Anschaffungsjahr</th> 
                <th>Ausgeliehen?</th>
                <th>Leihgebuehr</th>
                <th>Neupreis</th>
            </tr>
        </thead>

        <tfoot>
            <tr>
                <th>ID</th>
                <th>Buchtitel-Kennung</th>
                <th>Titel</th>
                <th>Anschaffungsjahr</th> 
                <th>Ausgeliehen?</th>
                <th>Leihgebuehr</th>
                <th>Neupreis</th>
            </tr>
        </tfoot>

        <tbody>
            @foreach ($buecher as $buch)
                <tr>
                    <td> {{ $buch->id }} </td>
                    <td> {{ $buch->kennung }} </td>
                    <td> <?php if($buch->buchtitel != null) echo $buch->buchtitel->titel; ?></td>
                    <td> {{ $buch->anschaffungsjahr }} </td>
                    <td> {{ $buch->ausgeliehen }} </td>
                    <td> {{ $buch->leihgebuehr }} </td>
                    <td> {{ $buch->neupreis }} </td>
                </tr>
            @endforeach
        </tbody>

    </table>

</div>

@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#buecher').DataTable();
        } );
    </script>
@stop