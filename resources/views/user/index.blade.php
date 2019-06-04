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

			<p>Auch im Schuljahr 2019/2020 bietet die Ursulaschule allen Familien an, ein, mehrere oder alle eingeführten Schulbücher eines Jahrgangs auszuleihen.</p>

			<p>Die Anmeldung zur Teilnahme an dem Leihverfahren muss bis zum <strong>21.6.2019</strong> erfolgen. Wer diese Frist nicht einhält, entscheidet sich damit, alle Lernmittel auf eigene Kosten zu beschaffen!</p>

			<p>Alle Schülerinnen und Schüler, die keine Bücher leihen wollen, können <a href="{{ url('user/buecherlisten') }}">hier</a> auch eine Liste der für das kommende Schuljahr aktuellen Bücher einsehen!</p>

			<p>Die Ausleihe einiger Bücher kann vorgeschrieben werden, wenn sie im Handel nicht mehr zu erhalten sind. Bestimmte Lernmittel (Bibel, Atlanten, Formelsammlung usw.) müssen Sie grundsätzlich selbst kaufen. Ansonsten ist die Teilnahme an dem Ausleihverfahren freiwillig und kann für jedes Schuljahr neu entschieden werden.</p>

			<p>Wie im letzten Jahr sind in der Liste die Ladenpreise und das von der Schule für die Ausleihe erhobene Entgelt angegeben. Die Leihgebühr für Schulbücher, die ein Jahr verwendet werden, beträgt ca. 33% des Kaufpreises. Für Schulbücher, die über mehrere Jahre verwendet werden, beträgt die Leihgebühr etwa 20% des Kaufpreises pro Schuljahr. Es wird jeweils aufgerundet.</p>

			<p>Bitte achten Sie bei ihrer Bestellung darauf, Schulbücher, die über mehrere Jahre ausgeliehen werden und daher über die Sommerferien in der Hand ihres Kindes bleiben, in der dafür vorgesehenen Spalte ("Verlängern") anzuklicken.</p> 

		</div>
	    
	    <div class="col-md-6">

			<p>Sie erhalten nach Abschluss des Verfahrens noch einmal übersichtlich dargestellt, welche Bücher Sie neu bestellt haben, welche über die Sommerferien in der Hand Ihres Kindes bleiben und welche Sie im Buchhandel kaufen müssen.</p>

			<p>Die Zahlung des Entgelts für die Ausleihe erfolgt per Bankeinzug von dem Konto, von dem auch das Schulgeld eingezogen wird. Sie müssen zum Abschluss der Bestellung bestätigen, dass sie mit diesem Verfahren einverstanden sind. Diese Einverständniserklärung gilt nur einmalig und muss in jedem Jahr erneuert werden.</p>
	 
			<p>Für Familien, die vom Schulgeld befreit sind, ist die Ausleihe kostenlos. Darüber hinaus wird die Leihgebühr für Familien mit drei oder mehr schulpflichtigen Kindern auf 80% reduziert. Der Nachweis über schulpflichtige Geschwisterkinder erfolgt per Upload der Schulbescheinigungen im Bestellverfahren oder - alternativ - durch Abgabe der Bescheinigungen im Sekretariat. Für Geschwisterkinder, die die Ursulaschule besuchen, entfällt die Nachweispflicht.</p>

			<a href="{{ url('user/anmeldung/schritt1') }}" class="btn btn-danger" role="button">Anmeldung zum Leihverfahren</a>

			<h4 style="color: red">Die Anmeldung für die Schulbuchleihe öffnet in Kürze.</h4>

	    </div>

	</div>

@endsection