<!doctype html>
<html>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title>A simple, clean, and responsive HTML invoice template</title>
	
	
	<!-- Favicon -->
	<link rel="icon" href="/images/favicon.png" type="image/x-icon">
	
	
	<!-- Invoice styling -->
	<style>
	body{
		font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
		text-align:center;
		color:#777;
	}
	
	body h1{
		font-weight:300;
		margin-bottom:0px;
		padding-bottom:0px;
		color:#000;
	}
	
	body h3{
		font-weight:300;
		margin-top:10px;
		margin-bottom:20px;
		font-style:italic;
		color:#555;
	}
	
	body a{
		color:#06F;
	}
	
	.invoice-box{
		max-width:800px;
		margin:auto;
		padding:30px;
		border:1px solid #eee;
		box-shadow:0 0 10px rgba(0, 0, 0, .15);
		font-size:16px;
		line-height:24px;
		font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
		color:#555;
	}
	
	.invoice-box table{
		width:100%;
		line-height:inherit;
		text-align:left;
	}
	
	.invoice-box table td{
		padding:5px;
		vertical-align:top;
	}
	
	.invoice-box table tr td:nth-child(2){
		text-align:right;
	}
	
	.invoice-box table tr.top table td{
		padding-bottom:20px;
	}
	
	.invoice-box table tr.top table td.title{
		font-size:45px;
		line-height:45px;
		color:#333;
	}
	
	.invoice-box table tr.information table td{
		padding-bottom:40px;
	}
	
	.invoice-box table tr.heading td{
		background:#eee;
		border-bottom:1px solid #ddd;
		font-weight:bold;
	}
	
	.invoice-box table tr.details td{
		padding-bottom:20px;
	}
	
	.invoice-box table tr.item td{
		border-bottom:1px solid #eee;
	}
	
	.invoice-box table tr.item.last td{
		border-bottom:none;
	}
	
	.invoice-box table tr.total td:nth-child(2){
		border-top:2px solid #eee;
		font-weight:bold;
	}
	
	@media only screen and (max-width: 600px) {
		.invoice-box table tr.top table td{
			width:100%;
			display:block;
			text-align:center;
		}
		
		.invoice-box table tr.information table td{
			width:100%;
			display:block;
			text-align:center;
		}
	}
	</style>
</head>

<body>
	<h1>A simple, clean, and responsive HTML invoice template</h1>
	<h3>Because sometimes, all you need is something simple.</h3>
		Find the code on <a href="https://github.com/sparksuite/simple-html-invoice-template">GitHub</a>. Licensed under the <a href="http://opensource.org/licenses/MIT" target="_blank">MIT license</a>.<br><br><br>
		
@foreach($models as $schueler)

    <div class="invoice-box pb_before pb_after">

        <table cellpadding="0" cellspacing="0">

            <tr class="top">
            
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="https://www.sparksuite.com/images/logo.png" style="width:100%; max-width:300px;">
                            </td>
                            
                            <td>
                                Invoice #: 123<br>
                                Created: January 1, 2015<br>
                                Due: February 1, 2015
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
            
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                Ursulaschule Osnabrück<br>
                                Kleine Domsfreiheit 11-18<br>
                                49078 Osnabrück
                            </td>
                            
                            <td>
                                Acme Corp.<br>
                                John Doe<br>
                                john@example.com
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="heading">
                <td>
                    Payment Method
                </td>
                
                <td>
                    Check #
                </td>
            </tr>
            
            <tr class="details">
                <td>
                    Check
                </td>
                
                <td>
                    1000
                </td>
            </tr>
            
            <tr class="heading">
                <td>Titel</td>
                <td>ID</td>
                <td>Kaufpreis</td>
				<td>Aufnahmedatum</td>
				<td>Alter in Jahren</td>
            </tr>

			@foreach($schueler->buecher as $buch)

				<tr class="item">
					<td>{{ $buch->buchtitel->titel }}</td>
					<td>{{ $buch->id }}</td>
					<td>{{ $buch->neupreis }}</td>
					<td>{{ $buch->aufnahme }}</td>
					<td>{{ (2019 - date_format($buch->aufnahme, 'Y')) }}</td>
				</tr>

			@endforeach
            
            
            <tr class="total">
                <td></td>
                
                <td>
                   Total: $385.00
                </td>
            </tr>

            <tr>
            	<td>
           		<h4>Ersatzpflicht bei Beschädigung oder nicht fristgerechter Rückgabe von Lernmitteln</h4>	
		
				<p>Ausgeliehene Lernmittel</p>

				<p>Sehr geehrte Dame, sehr geehrter Herr,</p>

				<p>Ihnen wurden die oben genannten Lernmittel leihweise überlassen. Diese wurden nicht bzw. beschädigt zurückgegeben, so dass eine weitere Ausleihe nicht möglich ist. Nach den von Ihnen anerkannten Ausleihbedingungen haben Sie Ersatz zu leisten durch Erstattung des Zeitwertes der Lernmittel.</p>

				<p><strong>Ich bitte Sie deshalb um Überweisung des Betrages von  10,00 € bis zum 26.6.2019 auf das folgende Konto:</strong></p>

		<pre>
  Ursulaschule Osnabrück
  IBAN: DE02 2655 0105 0000 2036 61
  BIC:  NOLADE22XXX
  Sparkasse Osnabrück
		</pre>

				<p>Im Zahlungsvordruck unbedingt angeben: Name der oder des Ersatzpflichtigen</p>

				<p>Mit freundlichen Grüßen</p>
				</td>
            </tr>

        </table>

    </div>
@endforeach

</body>

</html>