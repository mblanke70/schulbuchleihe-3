<html>
<head>
	<title>Label with Barcode</title>
	<style type="text/css">
		*  {padding: 0; margin: 0; font-family: Arial, sans-serif;}
	</style>
</head>
<body>
	<div>
		<div style="position:absolute; left: 0px; top: 0px; font-weight: bold; font-size: 18px;">PH__02_01</div>
		<div style="position:absolute; left: 0px; top: 40px;">9/17/18</div>
		<div style="position:absolute; right: 0px; top: 0px; text-align: center;">
			<img src="data:image/png;base64,{{ DNS1D::getBarcodePNG("42305", "C39", 2, 55) }}" alt="barcode"/><br />
			<span style="fon-size:20px;">42305</span>
		</div>
		<div style="position:absolute; left: 0px; top: 75px;">
			<p style="font-size:18px;">Universum 7/8</p>
			<p style="font-size:16px;">Ursulaschule Osnabr&uuml;ck</p>
			<p style="font-size:12px;">Dieses Buch ist Eigentum des Bistums Osnabr&uuml;ck. Dieses Buch ist pfleglich zu behandeln. Eintragungen, Randbemerkungen u.a. d&uuml;rfen nicht vorgenommen werden. Bei nicht fristgem&auml;&szlig;er R&uuml;ckgabe oder Besch&auml;digung wird die Schule Schadenersatz verlangen.</p>
		</div>
	</div>	
</body>
</html>
