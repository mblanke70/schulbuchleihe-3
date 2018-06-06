@extends('adminlte::page')

@section('title', 'Buchtitel')

@section('content_header')
    <h1>Buchtitel</h1>
@stop

@section('content')

<div class="box-body">
    <a class="btn btn-success" href="{{ url('admin/buchtitel/create') }}">Neuer Buchtitel</a>
</div>

<div class="box-body">

    <table id="buchtitel" class="display" cellspacing="0" width="100%">

        <thead>

            <tr>
                <th>ID</th>
                <th>Kennung</th>
                <th>ISBN</th>
                <th>Titel</th>
                <th>Verlag</th>
                <!--<th>Bestand</th>-->
                <!--<th>Ausgeliehen</th>-->
                <th>Preis</th>
                <th>Leihgebühr</th>
                <th>Aktion</th>
            </tr>

        </thead>

        <tfoot>

            <tr>
                <th>ID</th>
                <th>Kennung</th>
                <th>ISBN</th>
                <th>Titel</th>
                <th>Verlag</th>
                <!--<th>Bestand</th>-->
                <!--<th>Ausgeliehen</th>-->
                <th>Preis</th>
                <th>Leihgebühr</th>
                <th>Aktion</th>
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
                    <!--<td> {{ $t->bestand }} </td>-->
                    <!--<td> {{ $t->ausgeliehen }} </td>-->
                    <td> {{ $t->preis }} </td>
                    <td> {{ $t->leihgebuehr }} </td>

                    <td>    
                        <a data-toggle="modal" data-target="#modal-delete-{{ $t->id }}">
                            <i class="fa fa-fw fa-trash"></i>
                        </a>

                        <div class="modal modal-danger fade" id="modal-delete-{{ $t->id }}">   
                            <div class="modal-dialog modal-sm">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title">Please confirm</h4>
                                </div>
                                <div class="modal-body">
                                    <p class="lead">
                                        <i class="fa fa-question-circle fa-lg"></i>  
                                        Are you sure you want to delete this item?
                                    </p>
                                </div>
                                <div class="modal-footer">
                                    <form action="{{ url('admin/buchtitel/'.$t->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                    
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fa fa-times-circle"></i> Yes
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <a href="#" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $t->id }}').submit();">
                            <i class="fa fa-fw fa-trash"></i>
                        </a>
                       
                        <form id="delete-form-{{ $t->id }}" action="{{ url('admin/buchtitel/'.$t->id) }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                        </form>
                        
                        <a href="#" onclick="event.preventDefault(); document.getElementById('update-form-{{ $t->id }}').submit();">
                                <i class="fa fa-fw fa-pencil"></i>
                        </a>
                        
                        <form id="update-form-{{ $t->id }}" action="{{ url('admin/buchtitel/'.$t->id.'/edit') }}" method="GET" style="display: none;">
                            {{ csrf_field() }}                           
                        </form>
                        
                    <!--
                    <form action="{{ url('buchtitel/'.$t->id) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        <button type="submit">
                            <i class="fa fa-fw fa-trash"></i>
                        </button>
                    </form>
                        
                    <form action="{{ url('buchtitel/'.$t->id.'/edit') }}" method="GET">
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
            var table = $('#buchtitel').DataTable( {
                rowReorder: true,
                stateSave: true
            } );
        } );
    </script>
@stop