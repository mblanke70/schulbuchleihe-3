<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Bestellliste</title>
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style type="text/css">

      @import 'https://fonts.googleapis.com/css?family=PT+Sans:400,400italic,700&subset=latin,latin-ext,cyrillic,cyrillic-ext';
      
      table {
        border-collapse: collapse;
      }

      table, th, td {
        border: 1px solid black;
      }

      tr:nth-child(even) {
        background-color: #f2f2f2
      }

      body {
        font: normal 14px/1.5em 'PT Sans', Sans-serif;
      }

    </style>

  </head>

  <body>

    <table cellpadding="3">
      <tr>
        <th>Titel</th>
        <th>ISBN</th>
        <th>Kaufpreis</th>
        <!--<th>#bestellt</th>-->
        <!--<th>#verfügbar</th>-->
        <!--<th>#verfügbarMitInv</th>-->
        <th>Anzahl</th>
        <th>Summe</th>
      </tr>

  @foreach($liste as $buchtitel)
      <tr>
          <td>{{ $buchtitel->get('titel') }}</td>
          <td style="text-align: right;">{{ $buchtitel->get('isbn') }}</td>
          <td style="text-align: right;">{{ $buchtitel->get('kaufpreis') }} €</td>
          <!--<td>{{ $buchtitel->get('bestellt') }}</td>-->
          <!--<td>{{ $buchtitel->get('verfuegbar') }}</td>-->
          <!--<td>{{ $buchtitel->get('verfuegbarMitInventurstempel') }}</td>-->
          <td style="text-align: right;">{{ $buchtitel->get('anzahl') }}</td>
          <td style="text-align: right;">{{ $buchtitel->get('summe') }} €</td>
      </tr> 
  @endforeach

      <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td style="text-align: right;">{{ $gesamtanzahl }} </td>
          <td style="text-align: right;"><strong>{{ number_format($gesamtsumme, 2, ',', ' ') }} €</strong></td>
      </tr>
    
    </table>

  </body>
</html>
