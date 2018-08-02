@extends('adminlte::page')

@section('title', 'Bücher')

@section('content_header')
    <h1>Bücher</h1>
@stop

@section('content')

<div class="box-body">
    <a class="btn btn-success" href="{{ url('admin/buecher/create') }}">Neues Buch</a>
</div>

<div class="box-body">

    <table id="buecher" class="display" cellspacing="0" width="100%">

        <thead>
            <tr>
                <th>ID</th>
                <th>Kennung</th>
                <th>Titel</th>
                <th>Aufnahmedatum</th> 
                <th>Leihgebuehr</th>
                <th>Neupreis</th>
            </tr>
        </thead>

        <tfoot>
            <tr>
                <th>ID</th>
                <th>Kennung</th>
                <th>Titel</th>
                <th>Aufnahmedatum</th> 
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
                    <td> {{ $buch->aufnahmedatum }} </td>
                    <td> {{ $buch->leihgebuehr }} </td>
                    <td> {{ $buch->neupreis }} </td>
                </tr>
            @endforeach
        </tbody>

    </table>

</div>

@stop

@section('js')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
    
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#buecher').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'print'
                ]
            });
        } );
    </script>
@stop