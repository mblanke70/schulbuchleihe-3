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
                <th>Neupreis</th>
                <th>Label</th>
            </tr>
        </thead>

        <tfoot>
            <tr>
                <th>ID</th>
                <th>Kennung</th>
                <th>Titel</th>
                <th>Aufnahmedatum</th> 
                <th>Neupreis</th>
                <th>Label</th>
            </tr>
        </tfoot>

        <tbody>
            @foreach ($buecher as $buch)
                <tr>
                    <td> {{ $buch->id }} </td>
                    <td> <?php if($buch->buchtitel != null) echo $buch->buchtitel->kennung; ?> </td>
                    <td> <?php if($buch->buchtitel != null) echo $buch->buchtitel->titel; ?></td>
                    <td> {{ $buch->aufnahmedatum }} </td>
                    <td> {{ $buch->neupreis }} </td>
                    <td> 
                        <a href="{{ url('admin/buecher/label/'.$buch->id) }}"> 
                            <i class="fa fa-fw fa-eye"></i>
                        </a>

                        <a data-toggle="modal" data-url="{{ url('admin/buecher/'.$buch->id) }}" data-target="#modal-delete">
                            <i class="fa fa-fw fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>

</div>

<div id="modal-delete" class="modal modal-danger fade">   
    <div class="modal-dialog">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Schließen">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title">Bitte bestätigen</h4>
        </div>
        <div class="modal-body">
            <p>
                <i class="fa fa-question-circle fa-lg"></i>  
                Sind Sie sicher, dass dieses Buch gelöscht werden soll?
            </p>
        </div>
        <div class="modal-footer">
            <form action="" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
    
                <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
                <button type="submit" class="btn btn-danger"><i class="fa fa-times-circle"></i>Ja</button>
            </form>
        </div>
    </div>
</div>

@stop

@section('js')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
    
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script>
        $('#modal-delete').on('show.bs.modal', function(e) {
            var url = $(e.relatedTarget).data('url');
            $(e.currentTarget).find('form').attr('action', url);
        });

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