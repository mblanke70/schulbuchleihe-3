<meta http-equiv="content-type" content="text/html; charset=utf-8">

<style type="text/css" media="screen,print">

	* {
		padding: 0; 
		margin: 0; 
		font-family: Arial, sans-serif;
	}	

   	/* Page Breaks */

   	.pb_before {
       page-break-before: always !important;
   	}

   	.pb_after {
       page-break-after: always !important;
   	}

</style>

@foreach($buecher as $buch)

	<div class="pb_before pb_after">
		<!--
		<div style="font-weight: bold; font-size: 16px;">
			{{ $buch->buchtitel->kennung }}
		</div>
		-->
		<div style="text-align: center;">
			<img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($buch->id, "C39", 2, 55) }}" alt="barcode"/><br />
			<span style="font-size:18px;">{{ $buch->id }}</span>
		</div>
		<div>
			<p style="font-size:14px;">
				{{ \Carbon\Carbon::parse($buch->aufnahme)->format('d.m.Y') }}</div>
			</p>
			<p style="font-weight: bold; font-size:16px;">
				{{ html_entity_decode($buch->buchtitel->titel) }}
			</p>
			<p style="font-size:14px;">Ursulaschule&nbsp;Osnabr&uuml;ck</p>
			<p style="font-size:10px;">Dieses Buch ist Eigentum des Bistums Osnabr&uuml;ck. Dieses Buch ist pfleglich zu behandeln. Eintragungen, Randbemerkungen u.a. d&uuml;rfen nicht vorgenommen werden. Bei nicht fristgem&auml;&szlig;er R&uuml;ckgabe oder Besch&auml;digung wird die Schule Schadenersatz verlangen.</p>
		</div>
	</div>

@endforeach