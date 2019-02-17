<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>`
	<title>Labels}</title>
	<style type="text/css">
		*  {
			padding: 0; 
			margin: 0; 
			font-family: Arial, sans-serif;
		}	
	</style>
	<style type="text/css">
		div.page {
			overflow: hidden;
	        page-break-after: always;
	    }
	</style>
</head>
<body>

	@foreach($models as $buch)

	<div class="page">
		<div style="position:absolute; left: 0px; top: 0px; font-weight: bold; font-size: 18px;">
			{{ $buch->buchtitel->kennung }}
		</div>
		<div style="position: absolute; left: 0px; top: 40px;">{{ $buch->aufnahmedatum }}</div>
		<div style="position: absolute; right: 0px; top: 0px; text-align: center;">
			<img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($buch->id, "C39", 2, 55) }}" alt="barcode"/><br />
			<span style="font-size:20px;">{{ $buch->id }}</span>
		</div>
		<div style="position: absolute; left: 0px; top: 70px;">
			<p style="font-size:18px;">{{ htmlentities($buch->buchtitel->titel) }}</p>
		</div>
		<div style="position: absolute; left: 0px; top: 95px;">
			<p style="font-size:16px;">Ursulaschule&nbsp;Osnabr&uuml;ck</p>
		</div>
		<div style="position: absolute; left: 0px; top: 120px;">
			<p style="font-size:12px;">Dieses Buch ist Eigentum des Bistums Osnabr&uuml;ck. Dieses Buch ist pfleglich zu behandeln. Eintragungen, Randbemerkungen u.a. d&uuml;rfen nicht vorgenommen werden. Bei nicht fristgem&auml;&szlig;er R&uuml;ckgabe oder Besch&auml;digung wird die Schule Schadenersatz verlangen.</p>
		</div>
	</div>
	<p style="page-break-after: always;"/>
	<br/>

	@endforeach

</body>
</html>
