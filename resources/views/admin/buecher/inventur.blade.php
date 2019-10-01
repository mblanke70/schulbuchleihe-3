@extends('adminlte::page')

@section('title', 'Inventur')

@section('content_header')
    <h1>Inventur</h1>
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
		                Buch inventarisieren
		            </div>
		        </div>
		        <div>
		            <div class="box-body">
		                <div class="row">
		                    <form action="{{ url('admin/inventur') }}" method="POST" >                
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

		</div>

		@isset($buch)
		<div class="col-md-7">

			<div class="box box-solid box-success">   

                <div class="box-header with-border">
                    <div class="box-title">
                        Buchinfo
                    </div>
                </div>

                <div class="box-body">                    
					<table class="display compact" cellspacing="0" width="100%">
	                	<tr><th>Buch-ID</th><td>{{ $buch->id }}</td></tr>
	                	<tr><th>Aufnahmedatum</th><td>{{ $buch->aufnahmedatum }}</td></tr>
	                	<tr><th>gelöscht</th><td>{{ $buch->deleted_at }}</td></tr>
	                	<tr><th>ISBN</th><td>{{ $buch->buchtitel->isbn }}</td></tr>
	                	<tr><th>Kennung</th><td>{{ $buch->buchtitel->kennung }}</td></tr>
	                	<tr><th>Titel</th><td>{{ $buch->buchtitel->titel }}</td></tr>
	                	<tr><th>Fach</th><td>{{ $buch->buchtitel->fach->name }}</td></tr>
	                </table>
                </div>            
            
            </div>

		</div>
    	@endisset
    	
	</div>		

@stop

@section('js')

	<script>
		 $("#buch").focus();
	</script>
	
@stop