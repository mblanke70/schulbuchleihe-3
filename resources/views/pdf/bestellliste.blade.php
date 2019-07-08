<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Bestellliste</title>
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style type="text/css">

      table {
        border-collapse: collapse;
      }

      table, th, td {
        border: 1px solid black;
      }

      tr:nth-child(even) {
        background-color: #f2f2f2
      }

    </style>

  </head>

  <body>

    <table>
      <tr>
        <th>Titel</th>
        <th>ISBN</th>
        <th>#bestellt</th>
        <th>#verfügbar</th>
        <th>#verfügbarMitInv</th>
        <th>Anzahl</th>
      </tr>

  @foreach($liste as $buchtitel)
      <tr>
          <td>{{ $buchtitel->get('titel') }}</td>
          <td>{{ $buchtitel->get('isbn') }}</td>
          <td>{{ $buchtitel->get('bestellt') }}</td>
          <td>{{ $buchtitel->get('verfuegbar') }}</td>
          <td>{{ $buchtitel->get('verfuegbarMitInventurstempel') }}</td>
          <td>{{ $buchtitel->get('anzahl') }}</td>
      </tr> 
  @endforeach
    
    </table>

  </body>
</html>
