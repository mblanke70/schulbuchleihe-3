@extends('adminlte::page')

@section('title', 'Schuljahre')

@section('content_header')
    <h1>Schuljahre</h1>
@stop

@section('content')

<div class="box">
	<div class="box-header with-border">
		<h3 class="box-title">Schuljahre</h3>
		<div class="box-tools pull-right">
		  	<!--<a class="btn btn-block btn-success" href="{{ url('admin/schuljahre/create') }}">Neues Schuljahr</a>-->
		</div>
		<!-- /.box-tools -->
	</div>
	<!-- /.box-header -->

	<div class="box-body">
		<table id="schuljahre" class="display" cellspacing="0" width="100%">
	        <thead>
	            <tr>
	                <th>ID</th>
	                <th>Schuljahr</th>
	                <th>von</th>
	                <th>bis</th>
	                <th>aktiv</th>
	                <!-- <th>Aktion</th> -->
	            </tr>
	        </thead>
	        <tbody>
	        	@foreach ($schuljahre as $sj)
	                <tr>
	                    <td> {{ $sj->id }} </td>
	                    <td> {{ $sj->schuljahr }} </td>
	                    <td> {{ $sj->von }} </td>
	                    <td> {{ $sj->bis }} </td>
	                    <td> {{ $sj->aktiv }} </td>
	                    <!--
	                    <td>
 							<a href="{{ url('admin/schuljahre/'.$sj->id) }}"> 
 								<i class="fa fa-fw fa-eye"></i>
 							</a>

	                    	<a data-toggle="modal" data-url="{{ url('admin/schuljahre/'.$sj->id) }}" data-target="#modal-delete">
	                    		<i class="fa fa-fw fa-trash"></i>
	                    	</a>
	                    </td>
	                	-->
	                </tr>
	            @endforeach
	        </tbody>
    	</table>
	</div>
	<!-- /.box-body -->
	
	<div class="box-footer">
		The footer of the box
	</div>
	<!-- box-footer -->

</div>
<!-- /.box -->

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
                Sind Sie sicher, dass dieses Schuljahr gelöscht werden soll?
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

<script>
	$('#modal-delete').on('show.bs.modal', function(e) {
    	var url = $(e.relatedTarget).data('url');
		$(e.currentTarget).find('form').attr('action', url);
	});

    $(document).ready(function() {
        $('#schuljahre').DataTable();
    } );
</script>
@stop