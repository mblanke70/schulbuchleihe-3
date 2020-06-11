@extends('layouts.home')

@section('title', 'Schulbuchleihe - Ursulaschule Osnabrück')

@section('heading')
    <h4>{{ Auth::user()->vorname }} {{ Auth::user()->nachname }} ({{ Auth::user()->klasse }})</h4> 
@endsection

@section('content')
	
	@if ($errors->any())
	    <div class="alert alert-danger">
	        {{ $errors->first() }}
	    </div>
	@endif









 






 


 







	<div class="row">
	    <div class="col-md-6">

	    	<p><strong>Liebe Eltern, liebe Schülerinnen und Schüler!</strong></p>

			<p>Auch im Schuljahr 2020/2021 bietet die Ursulaschule allen Familien an, ein, mehrere oder alle eingeführten Schulbücher eines Jahrgangs auszuleihen.</p>

			<p>Die Anmeldung zur Teilnahme an dem Leihverfahren muss bis zum <strong>3.7.2020</strong> erfolgen. Wer diese Frist nicht einhält, entscheidet sich damit, alle Lernmittel auf eigene Kosten zu beschaffen!</p>
			
			<p>Die Ausleihe einiger Bücher kann vorgeschrieben werden, wenn sie im Handel nicht mehr zu erhalten sind. Bestimmte Lernmittel (Bibel, Atlanten, Formelsammlung usw.) müssen Sie grundsätzlich selbst kaufen. Ansonsten ist die Teilnahme an dem Ausleihverfahren freiwillig und kann für jedes Schuljahr neu entschieden werden.</p>

			<p>Wie im letzten Jahr sind in der Liste die Ladenpreise und das von der Schule für die Ausleihe erhobene Entgelt angegeben. Die Leihgebühr für Schulbücher, die ein Jahr verwendet werden, beträgt ca. 33% des Kaufpreises. Für Schulbücher, die über mehrere Jahre verwendet werden, beträgt die Leihgebühr etwa 20% des Kaufpreises pro Schuljahr. Es wird jeweils aufgerundet.</p>

			<p>Bitte achten Sie bei ihrer Bestellung darauf, Schulbücher, die über mehrere Jahre ausgeliehen werden und daher über die Sommerferien in der Hand ihres Kindes bleiben, in der Spalte „Verlängern“ anzuklicken.</p>

			<p>Für viele Bücher besteht im neuen Jahr die Möglichkeit, zusätzlich zum gedruckten Buch auch das digitale Schulbuch zu leihen. Wird diese Option „Print plus“ gewählt, so erhöht sich der Leihpreis des Buches um 1 €. Damit erhält man den Zugang zum E-Book über die jeweilige App der Lehrmittelverlage. (Ein E-Book ohne gedrucktes Buch ist über unsere Schulbuchleihe nicht erhältlich. Dies geht nur beim Verlag zu deutlich höheren E-Book-Preisen.)</p>

		</div>
	    
	    <div class="col-md-6">

	    	<p>Sie erhalten am Ende des Verfahrens noch einmal übersichtlich dargestellt, welche Bücher Sie neu bestellt haben, welche über die Sommerferien in der Hand Ihres Kindes bleiben und welche Sie im Buchhandel erwerben müssen. </p>

			<p>Die Zahlung des Entgelts für die Ausleihe und das Einsammeln der zusätzlichen Geldbeträge erfolgt per Bankeinzug. Kreuzen Sie daher bitte bei der online-Bestellung an, dass sie mit dem Verfahren einverstanden sind. Diese Einverständniserklärung gilt nur einmalig und muss in jedem Jahr erneuert werden.  Wir belasten den Betrag dem Konto, von dem auch das Schulgeld eingezogen wird.</p>
			
			<p>Für Familien, die vom Schulgeld befreit sind, ist die Ausleihe kostenlos. Darüber hinaus wird die Leihgebühr für Familien mit drei oder mehr schulpflichtigen Kindern auf 80% reduziert. Der Nachweis über schulpflichtige Geschwisterkinder erfolgt zu Beginn des neuen Schuljahres über den Upload der Schulbescheinigungen. Alternativ können diese Bescheinigungen auch im Sekretariat abgegeben werden. Für Geschwisterkinder, die die Ursulaschule besuchen, entfällt die Nachweispflicht.</p>

			<p><a href="{{ url('user/anmeldung/schritt1') }}" class="btn btn-danger" role="button">Anmeldung zum Leihverfahren</a></p>

			<p>Bei Rückfragen wenden Sie sich bitte direkt an Herrn Hoffmann (Di., Do., Fr. zwischen 8.00 und 9.00 Uhr, Tel. 0541/318741 oder <a href="mailto:matthias.hoffmann@urs-os.de">matthias.hoffmann@urs-os.de</a>). Bitte berücksichtigen Sie, dass unser Sekretariat keine Rückfragen beantworten kann!</p>

	    </div>

	</div>

@endsection