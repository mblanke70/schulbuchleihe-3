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

@foreach($models as $buch)

	<div class="pb_before pb_after">
		<div style="font-weight: bold; font-size: 16px;">
			{{ $buch->buchtitel->kennung }}
		</div>
		<!--<div style="">{{ $buch->aufnahmedatum }}</div>-->
		<div style="text-align: center;">
			<img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($buch->id, "C39", 2, 55) }}" alt="barcode"/><br />
			<span style="font-size:18px;">{{ $buch->id }}</span>
		</div>
		<div style="">
			<p style="font-weight: bold; font-size:16px;">
				{{ htmlentities($buch->buchtitel->titel) }}
			</p>
		</div>
		<div style="">
			<p style="font-size:14px;">Ursulaschule&nbsp;Osnabr&uuml;ck</p>
		</div>
		<div style="">
			<p style="font-size:10px;">Dieses Buch ist Eigentum des Bistums Osnabr&uuml;ck. Dieses Buch ist pfleglich zu behandeln. Eintragungen, Randbemerkungen u.a. d&uuml;rfen nicht vorgenommen werden. Bei nicht fristgem&auml;&szlig;er R&uuml;ckgabe oder Besch&auml;digung wird die Schule Schadenersatz verlangen.</p>
		</div>
	</div>

@endforeach