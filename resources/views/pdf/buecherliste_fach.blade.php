<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Bücherliste</title>
    
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
        font: normal 16px/1.5em 'PT Sans', Sans-serif;
      }

      .pb_before {
           page-break-before: always !important;
        }

      .pb_after {
           page-break-after: always !important;
      }

    </style>

  </head>

  <body>

    <div class="pb_before pb_after">

      <table cellpadding="3">

        <tr>
            <th>Titel</th>
            <th>Schuljahr</th>
            <th>ISBN</th>
            <th>Fach</th> 
            <th>Leihpreis</th>
            <th>Kaufpreis</th>
            <th>Jahrgänge</th>
        </tr>

  
        @foreach($models as $btsj)

          <tr>
              <td>{{ $btsj->buchtitel->titel }}</td>
              <td>{{ $btsj->schuljahr->schuljahr }}</td>
              <td>{{ $btsj->buchtitel->isbn }}</td>
              <td>{{ $btsj->buchtitel->fach->name }}</td>
              <td>{{ $btsj->leihpreis }}</td>
              <td>{{ $btsj->kaufpreis }}</td>

              <td>
                @foreach ($btsj->jahrgaenge as $jg)

                  {{ $jg->jahrgangsstufe . " " }}

                @endforeach                                 
           
              </td>
            
        </tr>
        
        @endforeach

           
      </table>

    </div>

  </body>

</html>