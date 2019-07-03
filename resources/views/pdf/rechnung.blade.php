<meta http-equiv="content-type" content="text/html; charset=utf-8">

<style type="text/css" media="screen,print">

	* {
		padding: 0; 
		margin: 0; 
		font-family: Arial, sans-serif;
	}	

	th {
		text-align: left;
	}

   	/* Page Breaks */

   	.pb_before {
       page-break-before: always !important;
   	}

   	.pb_after {
       page-break-after: always !important;
   	}

</style>

@foreach($models as $schueler)

	<div class="pb_before pb_after">
		
		<h4>Ersatzpflicht bei Beschädigung oder nicht fristgerechter Rückgabe von Lernmitteln</h4>

		<br />
		
		<p>Ausgeliehene Lernmittel {{ $schueler->vorname . " " . $schueler->nachname }}</p>

		<br />

		<table>

			<tr>
				<th>Titel des Lernmittels</th>
				<th>ID des Lernmittels</th>
				<th>Kaufpreis</th>
				<th>Aufnahmedatum</th>
				<th>Alter in Jahren</th>
			</tr>

			@foreach($schueler->buecher as $buch)

				<tr>
					<td>{{ $buch->buchtitel->titel }}</td>
					<td>{{ $buch->id }}</td>
					<td>{{ $buch->neupreis }}</td>
					<td>{{ $buch->aufnahme }}</td>
					<td>{{ (2019 - date_format($buch->aufnahme, 'Y')) }}</td>
				</tr>

			@endforeach

		</table>

		<br />

		<p>Sehr geehrte Dame, sehr geehrter Herr,</p>

		<br />

		<p>Ihnen wurden die oben genannten Lernmittel leihweise überlassen. Diese wurden nicht bzw. beschädigt zurückgegeben, so dass eine weitere Ausleihe nicht möglich ist. Nach den von Ihnen anerkannten Ausleihbedingungen haben Sie Ersatz zu leisten durch Erstattung des Zeitwertes der Lernmittel.</p>

		<br />

		<p><strong>Ich bitte Sie deshalb um Überweisung des Betrages von  10,00 € bis zum 26.6.2019 auf das folgende Konto:</strong></p>

		<pre>
  Ursulaschule Osnabrück
  IBAN: DE02 2655 0105 0000 2036 61
  BIC:  NOLADE22XXX
  Sparkasse Osnabrück
		</pre>

		<p>Im Zahlungsvordruck unbedingt angeben: Name der oder des Ersatzpflichtigen</p>

		<br />

		<p>Mit freundlichen Grüßen</p>

	</div>

@endforeach