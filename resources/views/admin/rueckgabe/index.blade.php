@extends('adminlte::page')

@section('title', 'Rückgabe')

@section('content_header')
    <h1>Rückgabe</h1>
@stop

@section('content')
	
	@if ($errors->any())
	    <div class="alert alert-danger">
	        <ul>
	            @foreach ($errors->all() as $error)
	                <li>{{ $error }}</li>
	            @endforeach
	        </ul>
	    </div>
	@endif

	<div class="row">
        
        <div class="col-md-5">

			<div class="box box-solid box-success">            
		        <div class="box-header with-border">                
		            <div class="box-title">
		                Buchrückgabe
		            </div>
		        </div>
		        <div>
		            <div class="box-body">
		                <div class="row">
		                    <form action="{{ url('admin/rueckgabe/') }}" method="POST" >                
		                        {{ csrf_field() }}      
		                        <div class="col-md-6">
		                            <div class="form-group">   
		                                <input type="text" class="form-control" id="buch" name="buch_id" />
		                            </div>
		                        </div>
		                        <div class="col-md-6">
		                            <div>
		                                <button type="submit" class="btn btn-success">Abschicken</button>
		                            </div>
		                        </div>
		                    </form>
		                </div>
		            </div>
		        </div>
		    </div>

		    @isset($buch)
		    	@isset($ausleiher)
		    <div class="box box-solid box-danger">            
		        <div class="box-header with-border">                
		            <div class="box-title">
		                Buch
		            </div>
		        </div>
		        <div>
		            <div class="box-body">
		            	<p>
		       				<strong>Titel</strong>: {{ $buch->buchtitel->titel }}
		       			</p>
		       			<p>
		       				<strong>ID</strong>: {{ $buch->id }}
		       			</p>
		       			<p>
		       				<strong>Fach</strong>: {{ $buch->buchtitel->fach->code }}
		       			</p>
		       			<p>
		       				<strong>Ausleiher</strong>: {{ $ausleiher->vorname . ' ' . $ausleiher->nachname }}
		       			</p>
		            </div>
		        </div>
		    </div>
		    	@endisset
		    @endisset

		</div>

		@isset($buecher)

		<div class="col-md-7">

			<div class="box box-solid box-warning">            
		        <div class="box-header with-border">                
		            <div class="box-title">
		                Ausgeliehene Bücher: {{ $ausleiher->vorname .' '. $ausleiher->nachname }}
		            </div>
		        </div>
		        <div>
		            <div class="box-body">
		                
		                <div class="table-responsive">
	                        <table id="buecher" class="display compact" cellspacing="0" width="100%">
	                            <thead>
	                                <tr>
	                                    <th width="7%">Fach</th> 
	                                    <th width="13%">ID</th> 
	                                    <th width="60%">Titel</th>
	                                </tr>
	                            </thead>
	                            <tbody>
	                                @foreach ($buecher as $b)
	                                <tr>
	                                    <td>{{ $b->buchtitel->fach->code }}</td>
	                                    <td>{{ $b->id }}</td>
	                                    <td>{{ $b->buchtitel->titel }}</td>
	                                </tr>
	                                @endforeach
	                            </tbody>
	                        </table>
	                    </div>

		            </div>
		        </div>
		    </div>

		</div>

		@endisset
    	
	</div>		

@stop

@section('js')

    <script>
        $(document).ready(function() {

            $('#buecher').DataTable({
                "searching": false, 
                "info": false, 
                "paging": false,
                "language": {
                    "emptyTable": "Keine Bücher ausgeliehen."
                },           
            });

            $("#buch").focus();

        } );
    </script>

@stop