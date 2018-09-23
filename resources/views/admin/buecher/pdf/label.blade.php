<html>
<head>
	<title>Label #{{$buch->id}}</title>
	<style type="text/css">
		*  {padding: 0; margin: 0; font-family: Arial, sans-serif;}
	</style>
</head>
<body>
	<div>
		<div style="position:absolute; left: 0px; top: 0px; font-weight: bold; font-size: 18px;">
			{{ $buch->buchtitel->kennung }}
		</div>
		<div style="position:absolute; left: 0px; top: 40px;">{{ $buch->aufnahmedatum }}</div>
		<div style="position:absolute; right: 0px; top: 0px; text-align: center;">
			<img src="data:image/png;base64,{{ DNS1D::getBarcodePNG("42305", "C39", 2, 55) }}" alt="barcode"/><br />
			<span style="fon-size:20px;">{{ $buch->id }}</span>
		</div>
		<div style="position:absolute; left: 0px; top: 80px;">
			<p style="font-size:18px;">{{ htmlentities($buch->buchtitel->titel) }}</p>
		</div>
		<div style="position:absolute; left: 0px; top: 105px;">
			<p style="font-size:16px;">Ursulaschule Osnabr&uuml;ck</p>
			<p style="font-size:12px;">Dieses Buch ist Eigentum des Bistums Osnabr&uuml;ck. Dieses Buch ist pfleglich zu behandeln. Eintragungen, Randbemerkungen u.a. d&uuml;rfen nicht vorgenommen werden. Bei nicht fristgem&auml;&szlig;er R&uuml;ckgabe oder Besch&auml;digung wird die Schule Schadenersatz verlangen.</p>
		</div>
	</div>	
</body>
</html>
