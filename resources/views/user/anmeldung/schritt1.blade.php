@extends('layouts.home')

@section('title', 'Anmeldung zur Buchausleihe im Schuljahr 2020/21')

@section('heading')
    <h4>Anmeldung (Schritt 1/4)</h4>
    <h4>{{ $user->vorname }} {{ $user->nachname }} ({{ $user->klasse }})</h4> 
@endsection

@section('content')
	
	@if ($errors->any())
	    <div class="alert alert-danger">
	        {{ $errors->first() }}
	    </div>
	@endif

<form action="{{ url('user/anmeldung/schritt1') }}" method="POST" role="form">

    {{ csrf_field() }}

	<div class="row">
        <div class="col-md-6">
	       	<h4>Rechnungsanschrift</h4>
	       	<p>Zur Rechnungsstellung benötigen wir die Anschrift eines Erziehungsberechtigten. Die Email-Adresse wird für den Versand einer Bestätigungs-Mail nach abgeschlossener Anmeldung benötigt.</p>

	       	<fieldset class="form-group">
				<div class="row">
			      	<legend class="col-form-label col-sm-2 pt-0">Anrede</legend>

					<div class="col-sm-10">
						<div class="custom-control custom-radio custom-control-inline">
						 	<input class="custom-control-input" type="radio" name="geschlecht" id="maennlich" value="m" 
						 	@isset($familie) 
						 		@if($familie->re_geschlecht=='m')
						 			{{ checked }} 
						 		@endif  
						 	@endisset>
						  	<label class="custom-control-label" for="maennlich">Herr</label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
						  	<input class="custom-control-input" type="radio" name="geschlecht" id="weiblich" value="w" 
						  	@isset($familie) 
						 		@if($familie->re_geschlecht=='w')
						 			{{ checked }} 
						 		@endif  
						 	@endisset>
						  	<label class="custom-control-label" for="weiblich">Frau</label>
					</div>
				</div>
			</fieldset>

			<div class="form-group row">
			   	<label for="vorname" class="col-sm-2 col-form-label">Vorname</label>
			   	<div class="col-sm-10">
			    	<input type="text" class="form-control" name="vorname" id="vorname" value="@isset($familie) {{ $familie->re_vorname }} @endisset">
			  	</div>
			 </div>
			<div class="form-group row">			 
	  	    	<label for="nachname" class="col-sm-2 col-form-label">Nachname</label>
	  	    	<div class="col-sm-10">
		    		<input type="text" class="form-control" name="nachname" id="nachname" value="@isset($familie) {{ $familie->re_nachname }} @endisset">
			  	</div>
			</div>
			<div class="form-group row">			 
				<label for="strasse" class="col-sm-2 col-form-label">Straße</label>
				<div class="col-sm-10">
				   	<input type="text" class="form-control" name="strasse" id="strasse"
				   	value="@isset($familie) {{ $familie->re_strasse_nr }} @endisset">
				</div>
			</div>
			<div class="form-group row">			 
			   	<label for="ort" class="col-sm-2 col-form-label">Ort</label>
			   	<div class="col-sm-10">
				   	<input type="text" class="form-control" name="ort" id="ort" value="@isset($familie) {{ $familie->ort }} @endisset">
				</div>
			</div>
			<div class="form-group row">			 
			  	<label for="email" class="col-sm-2 col-form-label">Email</label>
			   	<div class="col-sm-10">
			  		<input type="email" class="form-control" name="email" id="email" value="@isset($familie) {{ $familie->email }} @endisset">
			  	</div>
			</div>			

<!--
          	@isset($user->familie)
	
				<div class="table-responsive">
	            	<table class="table table-striped table-sm">    	
						<caption>Geschwisterkinder an der Ursulaschule</caption>
	                	<thead>
		                    <tr>
		                        <th>Vorname</th> 
		                        <th>Name</th> 
		                    </tr>
	                	</thead>

		                <tbody>
							@foreach($user->familie->users as $geschwister)
								<tr>
									<td>{{ $geschwister->vorname }}</td>
		                        	<td>{{ $geschwister->nachname }}</td>
								</tr>
							@endforeach			
		                </tbody>
		            </table>
		        </div>

   			@endisset
-->

        </div>
        <div class="col-md-6">

			<h4>Erm&auml;&szlig;igung auf den Leihpreis</h4>
        	
        	<p>Familien mit drei oder mehr schulpflichtigen Kindern bezahlen für jedes Kind nur 80 Prozent des Entgelts für die Ausleihe. Der Nachweis über schulpflichtige Geschwisterkinder, die nicht an der Ursulaschule sind, erfolgt durch Abgabe von Schulbescheinigungen. Diese können entweder nach Abschluss der Anmeldung auf dieser Seite per Upload übermittelt oder im Sekretariat abgegeben werden.</p>

        	<p>Familien, die von der Zahlung eines Entgelt für die Ausleihe befreit sind, müssen dies ebefalls durch Upload bzw. Abgabe einer entsprechenden Bescheinigung nachweisen.</p>

      		<!--
        	<div class="input-group mb-3">
				<div class="input-group-prepend">
					<label class="input-group-text" for="ermaessigung">Ermäßigung</label>
	  			</div>
        	
                <select id="ermaessigung" class="custom-select" name="ermaessigung">
                    <option value="0" selected>keine Erm&auml;&szlig;igung</option>
                    <option value="1">20% Erm&auml;&szlig;igung (3 Kinder)</option>
                    <option value="2">100% Erm&auml;&szlig;igung (befreit)</option>
                </select>
            </div>
			-->

	       	<h4>Jahrgang im Schuljahr 2020/21</h4>
            <p>Geben Sie an, in welchem Jahrgang sich ihr Kind im nächsten Schuljahr befindet. (Es sollte der richtige Jahrgang vorausgewählt sein.)</p>
            <div class="input-group mb-3">
				<div class="input-group-prepend">
					<label class="input-group-text" for="jahrgang">Jahrgang</label>
	  			</div>
			  	<select class="custom-select" id="jahrgang" name="jahrgang">
				@foreach ($jahrgaenge as $jg)
			    	<option value="{{ $jg->id }}" 
			    		@if ($jahrgang==$jg->jahrgangsstufe) selected @endif 
			    	>
			    		{{ $jg->jahrgangsstufe }} ({{ $jg->schuljahr->schuljahr }})
			    	</option>	
				@endforeach
			  	</select>
			</div>

<!--
			<h4 class="mt-4">Bankverbindung</h4>

            <p>Geben Sie das Konto an, von dem auch das Schulgeld für Ihr Kind eingezogen wird. Von diesem Konto werden wir am Anfang des nächsten Schuljahres auch die Leihgebühren einziehen. Diese Angabe hilft uns, dass für das Schulgeld von Ihnen erteilte Lastschriftmandat richtig zuzuordnen.</p>
           
		  	<div class="input-group mb-3">
			  	<div class="input-group-prepend">
			    	<span class="input-group-text">Kontoinhaber</span>
			  	</div>
			  	<input type="text" class="form-control" name="kontoinhaber">
			</div>

			<div class="input-group mb-3">
			  	<div class="input-group-prepend">
			    	<span class="input-group-text">IBAN</span>
			  	</div>
			  	<input type="text" class="form-control" name="iban">
			</div>
-->
        </div>
  	</div>

	<div>
		<button type="submit" class="btn btn-primary">Weiter</button>
	</div>
	
</form>

@endsection