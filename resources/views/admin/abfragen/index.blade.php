@extends('adminlte::page')

@section('title', 'Abfragen')

@section('content_header')
    <h1>Abfragen</h1>
@stop

@section('content')

<div class="box-body">
    <a class="btn btn-success" href="{{ url('admin/abfragen/create') }}">Neue Abfrage
    </a>
</div>

<div class="box-body">

    <table id="abfragen" class="display" cellspacing="0" width="100%">

        <thead>

            <tr>
                <th>ID</th>
                <th>Child_ID</th>
                <th>Parent_ID</th>
                <th>Jahrgang</th>
                <th>Titel</th>
                <th>Aktion</th>
            </tr>

        </thead>

        <tfoot>

            <tr>
                <th>ID</th>
                <th>Child_ID</th>
                <th>Parent_ID</th>
                <th>Jahrgang</th>
                <th>Titel</th>
                <th>Aktion</th>
            </tr>

        </tfoot>

        <tbody>

            @foreach ($abfragen as $a)
            
                <tr>
                    <td> {{ $a->id }} </td>
                    <td> {{ $a->child_id }} </td>
                    <td> {{ $a->parent_id }} </td>
                    <td> {{ $a->jahrgang }} </td>
                    <td>
                        <a href="{{ url('admin/abfragen/'.$a->id) }}"> {{ $a->titel }} </a>
                    </td>
                    <td>    
                        <a data-toggle="modal" data-target="#modal-delete-{{ $a->id }}"
                            <i class="fa fa-fw fa-trash"></i>
                        </a>

                        <div class="modal modal-danger fade" id="modal-delete-{{ $a->id }}">   
                            <div class="modal-dialog modal-sm">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title">Bitte bestätigen</h4>
                                </div>
                                <div class="modal-body">
                                    <p class="lead">
                                        <i class="fa fa-question-circle fa-lg"></i>  
                                        Soll die Abfrage gelöscht werden?
                                    </p>
                                </div>
                                <div class="modal-footer">
                                    <form action="{{ url('admin/abfragen/'.$a->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                    
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fa fa-times-circle"></i> Ja
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!--
                        <a href="#" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $a->id }}').submit();">
                            <i class="fa fa-fw fa-trash"></i>
                        </a>
                       
                        <form id="delete-form-{{ $a->id }}" action="{{ url('admin/abfragen/'.$a->id) }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                        </form>
                        -->
                        
                        <a href="#" onclick="event.preventDefault(); document.getElementById('update-form-{{ $a->id }}').submit();">
                                <i class="fa fa-fw fa-pencil"></i>
                        </a>
                        
                        <form id="update-form-{{ $a->id }}" action="{{ url('admin/abfragen/'.$a->id.'/edit') }}" method="GET" style="display: none;">
                            {{ csrf_field() }}                           
                        </form>
                        
                    <!--
                    <form action="{{ url('admin/abfragen/'.$a->id) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        <button type="submit">
                            <i class="fa fa-fw fa-trash"></i>
                        </button>
                    </form>
                        
                    <form action="{{ url('admin/abfragen/'.$a->id.'/edit') }}" method="GET">
                        {{ csrf_field() }}
                       
                        <button type="submit">
                            <i class="fa fa-fw fa-pencil"></i>
                        </button>
                    </form>
                    -->

                    </td>
                </tr>

            @endforeach

        </tbody>

    </table>



</div>

@stop

@section('js')
    <script>
        $(document).ready(function() {
            var table = $('#abfragen').DataTable( {
                rowReorder: true,
                stateSave: true
            } );
        } );
    </script>
@stop