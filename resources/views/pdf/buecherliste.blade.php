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

     <h1>Bücherliste: {{ $schueler->nachname }} , {{ $schueler->vorname }} ({{ $schueler->klasse->bezeichnung }})</h1>

    <table cellpadding="3">
      <tr>
          <th>ausgeliehen?</th>
          <th>Fach</th> 
          <th>Titel</th>
          <th>Bestellstatus</th>
      </tr>

      @foreach ($buchtitel->sortBy('wahl') as $bt)
      <tr>                                    
          <td>
              @if ($bt->ausgeliehen) ja @endif 
          </td>
          <td>{{ $bt->buchtitel->fach->code }}</td>
          <td>{{ $bt->buchtitel->titel }}</td>
          <td>  
              @if($bt->wahl==1)  
                  leihen
              @elseif($bt->wahl==2)
                  verlängern
              @elseif($bt->wahl==3)
                  kaufen
              @else($bt->wahl==4)
                  nicht gewählt
              @endif
          </td>
      </tr>
      @endforeach
    
    </table>

  </body>
</html>
