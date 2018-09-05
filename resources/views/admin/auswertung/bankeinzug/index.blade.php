@extends('adminlte::page')

@section('title', 'Bankeinzug')

@section('content_header')
    <h1>Bankeinzug</h1>
@stop

@section('content')


<div class="box">

    <div class="box-header with-border">
        <h3 class="box-title">Schüler</h3>
        <div class="box-tools pull-right">
            <!-- Buttons, labels, and many other things can be placed here! -->
            <!-- Here is a label for example -->
          
        </div>
        <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->

    <div class="box-body">

        <table id="schueler" class="display" cellspacing="0" width="100%">

            <thead>
                <tr>
                    <th>Name</th>
                    <th>Vorname</th>
                    <th>Klasse</th>
                    <th>Leihgebühr</th>
                    <th>Leihgebühr (erm.)</th>
                    <th>Zusatzkosten</th>
                    <th>Gesamtbetrag</th>
                </tr>
            </thead>

            <tbody>
            @foreach ($schueler as $user)
                <tr>
                    <td> {{ $user->nachname }} </td>
                    <td> {{ $user->vorname }} </td>
                    <td> {{ $user->klasse }} </td>
                    <td> {{ $user->summe }} </td>
                    <td> {{ $user->summeErm }} </td>
                    <td> {{ $user->zusatzkosten }} </td>
                    <td> {{ $user->gesamt }} </td>
                </tr>
            @endforeach
            </tbody>

        </table>

    </div>
</div>
<!-- /.box -->

@stop

@section('js')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
    
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#schueler').DataTable({
                order: [[ 3, "asc" ]],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'print'
                ]
            });
        } );
    </script>
@stop