@extends('adminlte::page')

@section('title', 'Rückgabe')

@section('content_header')
    <h1>Rückgabe: {{ $ausleiher->vorname .' '. $ausleiher->nachname }} ({{ $ausleiher->klasse->bezeichnung }} - {{ $ausleiher->klasse->jahrgang->schuljahr->schuljahr }})</h1>
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
		                    <form action="{{ url('admin/rueckgabe/' . $ausleiher->id) }}" method="POST" >                
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
				                Buch zurückgenommen
				            </div>
				        </div>
				        <div>
				            <div class="box-body">
				            	<p>Titel: {{ $buch->buchtitel->titel }}</p>
				       			<p>ID: {{ $buch->id }}</p>
				       			<p>Fach: {{ $buch->buchtitel->fach->name }}</p>
				       			<p>Aufnahme: <strong>{{ date_format($buch->aufnahme, 'd.m.Y') }}</strong></p>
				       			<p>
				       				Leih-Historie:

				       				<div class="table-responsive">
					       				<table id="historie" class="display compact" cellspacing="0" width="100%">
					       					<thead>
				                                <tr>
				                                    <th>Nachname</th> 
				                                    <th>Vorname</th> 
				                                    <th>Klasse</th>
				                                    <th>Schuljahr</th> 
				                                </tr>
				                            </thead>
				                            <tbody>
							       				@foreach($buch->historie as $eintrag)
							       					<tr>
							       						<td>{{ $eintrag->nachname }}</td>
							       						<td>{{ $eintrag->vorname }}</td>
							       						<td>{{ $eintrag->klasse }}</td>
							       						<td>{{ $eintrag->schuljahr }}</td>
							       					</tr>
							       				@endforeach
							       			</tbody>
					       				</table>
					       			</div>
				       			</p>

				       			<form action="{{ url('admin/rueckgabe/' .$ausleiher->id . '/' . $buch->id) }}" method="POST" >                
			                        {{ csrf_field() }}      
		                            <div>
		                                <button type="submit" name="loeschen" value="0" class="btn btn-danger">Buch löschen</button>

		                                <button type="submit" name="rechnung" value="1" class="btn btn-danger">Buch löschen + Rechnung</button>
			                        </div>
			                    </form>

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
		                Ausgeliehene Bücher {{$ausleiher->klasse->jahrgang->schuljahr->schuljahr}} [{{ $ausleiher->id }}]
		            </div>
		        </div>
		        <div>
		            <div class="box-body">
		                
		                <div class="table-responsive">
	                        <table id="buecher" class="display compact" cellspacing="0" width="100%">
	                            <thead>
	                                <tr>
	                                    <th width="10%">Fach</th> 
	                                    <th width="5%">ID</th> 
	                                    <th width="75%">Titel</th>
	                                    <th width="10%">Aktion</th>
	                                </tr>
	                            </thead>
	                            <tbody>
	                                @foreach ($buecher as $b)
	                                <tr>
	                                    <td>{{ $b->buchtitel->fach->code }}</td>
	                                    <td>{{ $b->id }}</td>
	                                    <td>{{ $b->buchtitel->titel }}</td>
	                                    <td>
	                                    	@isset($ausleiher_neu)
		                                    	<form action="{{ url('admin/rueckgabe/verlaengern/' .$ausleiher->id . '/' . $b->id) }}" method="POST" >                
				                      				  {{ csrf_field() }}      
			                            			<div>
			                                			<button type="submit" class="btn btn-light btn-sm">Verlängern</button>
							                        </div>
							                    </form>
						                    @endisset
	                                    </td>
	                                </tr>
	                                @endforeach
	                            </tbody>
	                        </table>
	                    </div>

		            </div>
		        </div>
		    </div>

    	
			@isset($ausleiher_neu)


				<div class="box box-solid box-warning">            
			        <div class="box-header with-border">                
			            <div class="box-title">
			                Ausgeliehene Bücher {{$ausleiher_neu->klasse->jahrgang->schuljahr->schuljahr}} [{{ $ausleiher_neu->id }}]
			            </div>
			        </div>
			        <div>
			            <div class="box-body">
			                
			                <div class="table-responsive">
		                        <table id="buecher2" class="display compact" cellspacing="0" width="100%">
		                            <thead>
		                                <tr>
		                                    <th width="10%">Fach</th> 
		                                    <th width="5%">ID</th> 
		                                    <th width="85%">Titel</th>
		                                </tr>
		                            </thead>
		                            <tbody>
		                                @foreach ($ausleiher_neu->buecher as $b)
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

				@endisset

			@endisset

		</div>

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

            $('#buecher2').DataTable({
                "searching": false, 
                "info": false, 
                "paging": false,
                "language": {
                    "emptyTable": "Keine Bücher ausgeliehen."
                },           
            });

            $('#historie').DataTable({
                "searching": false, 
                "info": false, 
                "paging": false,           
            });

            $("#buch").focus();

        } );
    </script>

@stop