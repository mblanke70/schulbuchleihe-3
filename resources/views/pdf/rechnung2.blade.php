<!DOCTYPE html>
<!--
  Invoice template by invoicebus.com
  To customize this template consider following this guide https://invoicebus.com/how-to-create-invoice-template/
  This template is under Invoicebus Template License, see https://invoicebus.com/templates/license/
-->
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Rechnung</title>
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <style type="text/css">
        
        /*
        @font-face {
          font-family: 'PT Sans', sans-serif;;
          src: url('PT_Sans-Web-Regular.ttf');
        }
        */
        
        @import 'https://fonts.googleapis.com/css?family=PT+Sans:400,400italic,700&subset=latin,latin-ext,cyrillic,cyrillic-ext';

        /*
        @import url("https://fonts.googleapis.com/css?family=PT+Sans:400,400italic,700&subset=latin,latin-ext,cyrillic,cyrillic-ext");
        */
        
        html, body, div, span, applet, object, iframe,
        h1, h2, h3, h4, h5, h6, p, blockquote, pre,
        a, abbr, acronym, address, big, cite, code,
        del, dfn, em, img, ins, kbd, q, s, samp,
        small, strike, strong, sub, sup, tt, var,
        b, u, i, center,
        dl, dt, dd, ol, ul, li,
        fieldset, form, label, legend,
        table, caption, tbody, tfoot, thead, tr, th, td,
        article, aside, canvas, details, embed,
        figure, figcaption, footer, header, hgroup,
        menu, nav, output, ruby, section, summary,
        time, mark, audio, video {
          margin: 0;
          padding: 0;
          border: 0;
          font: inherit;
          font-size: 100%;
          vertical-align: baseline;
        }

        html {
          line-height: 1;
        }

        ol, ul {
          list-style: none;
        }

        table {
          border-collapse: collapse;
          border-spacing: 0;
        }

        caption, th, td {
          text-align: left;
          font-weight: normal;
          vertical-align: middle;
        }

        q, blockquote {
          quotes: none;
        }
        q:before, q:after, blockquote:before, blockquote:after {
          content: "";
          content: none;
        }

        a img {
          border: none;
        }

        article, aside, details, figcaption, figure, footer, header, hgroup, main, menu, nav, section, summary {
          display: block;
        }

        /* Invoice styles */
        /**
         * DON'T override any styles for the <html> and <body> tags, as this may break the layout.
         * Instead wrap everything in one main <div id="container"> element where you may change
         * something like the font or the background of the invoice
         */
        html, body {
          /* MOVE ALONG, NOTHING TO CHANGE HERE! */
        }

        /** 
         * IMPORTANT NOTICE: DON'T USE '!important' otherwise this may lead to broken print layout.
         * Some browsers may require '!important' in oder to work properly but be careful with it.
         */
        .clearfix {
          display: block;
          clear: both;
        }

        .hidden {
          display: none;
        }

        b, strong, .bold {
          font-weight: bold;
        }

        #container {
          font: normal 16px/1.5em 'PT Sans', Sans-serif;
          margin: 0 auto;
          padding: 60px;
          min-height: 1038px;
        }

        #memo .logo {
          float: left;
          margin-right: 20px;
        }
        #memo .logo img {
          width: 200px;
          height: 80px;
        }
        #memo .company-info {
          float: right;
          text-align: right;
        }
        #memo .company-info > div:first-child {
          display: inline-block;
          line-height: 1em;
          font-weight: bold;
          font-size: 30px;
          margin-bottom: 10px;
        }
        #memo .company-info span {
          font-size: 14px;
          /*display: inline-block;*/
          margin-bottom: 1px;
          min-width: 20px;
          color: #888;
        }
        #memo:after {
          content: '';
          display: block;
          clear: both;
        }

        #invoice-title-number {
          margin-top: 0px;
        }
        #invoice-title-number span {
          margin-right: 10px;
          display: inline-block;
          min-width: 20px;
        }
        #invoice-title-number #title {
          text-align: right;
          font-size: 25px;
          font-weight: bold;
        }
        #invoice-title-number #number {
          font-size: 16px;
          color: #888;
          text-align: left;
        }

        #client-info {
          float: left;
          margin-top: 10px;
          min-width: 220px;
        }
        #client-info > div {
          margin-bottom: 3px;
          min-width: 20px;
        }
        #client-info .client-name {
          font-weight: bold;
          font-size: 18px;
          margin: 10px 0;
        }
        #client-info span {
          display: block;
          min-width: 20px;
        }
        #client-info > span {
          color: #888;
        }

        table {
          table-layout: fixed;
        }
        table th, table td {
          vertical-align: top;
          word-break: keep-all;
          word-wrap: break-word;
        }

        #invoice-info {
          float: right;
          margin-top: 40px;
        }
        #invoice-info > div {
          float: left;
        }
        #invoice-info > div > span {
          display: block;
          min-width: 20px;
          min-height: 18px;
          margin-bottom: 3px;
        }
        #invoice-info > div:first-child {
          color: #888;
        }
        #invoice-info > div:last-child {
          margin-left: 30px;
          text-align: right;
        }
        #invoice-info:after {
          content: '';
          display: block;
          clear: both;
        }

        #items {
          margin-top: 50px;
        }
        #items .first-cell, #items table th:first-child, #items table td:first-child {
          width: 10px;
          text-align: right;
        }
        #items table {
          border-collapse: separate;
          width: 100%;
          border-bottom: 1px solid #ccc;
        }
        #items table th {
          font-weight: bold;
          padding: 12px;
          text-align: right;
          border-bottom: 1px solid #ccc;
        }
        #items table th:first-child {
          padding-left: 0 !important;
        }
        #items table th:nth-child(2) {
          width: 30%;
          text-align: left;
        }
        #items table th:last-child {
          text-align: right;
          padding-right: 0 !important;
        }
        #items table td {
          padding: 12px;
          text-align: right;
        }
        #items table td:first-child {
          text-align: left;
          padding-left: 0 !important;
        }
        #items table td:nth-child(2) {
          text-align: left;
        }
        #items table td:last-child {
          padding-right: 0 !important;
        }

        .currency {
          font-size: 11px;
          font-style: italic;
          color: #888;
          margin-top: 5px;
        }

        #sums {
          float: right;
          page-break-inside: avoid;
        }
        #sums table tr th, #sums table tr td {
          min-width: 100px;
          padding: 10px 0;
          text-align: right;
        }
        #sums table tr th {
          text-align: left;
          padding-right: 30px;
          color: #888;
        }
        #sums table tr.amount-total th {
          text-transform: uppercase;
          color: black;
        }
        #sums table tr.amount-total th, #sums table tr.amount-total td {
          font-size: 15px;
          font-weight: bold;
        }
        #sums table tr:last-child th {
          text-transform: uppercase;
          color: black;
        }
        #sums table tr:last-child th, #sums table tr:last-child td {
          font-size: 15px;
          font-weight: bold;
        }

        #terms {
          margin: 20px 0 20px 0;
          page-break-inside: avoid;
        }

        #terms .logo2 img {
          width: 176px;
          height: 100px;
        }

        #terms > span {
          /*display: inline-block;*/
          min-width: 20px;
          font-weight: bold;
        }
        #terms > div {
          margin-top: 10px;
          min-height: 50px;
          min-width: 50px;
        }

        .payment-info div {
          margin-top: 20px;
          /*color: #888;*/
          font-size: 16px;
          /*display: inline-block;*/
          min-width: 20px;
          text-align: center;
        }

        .ib_bottom_row_commands {
          margin-top: 35px !important;
        }

        /**
         * If the printed invoice is not looking as expected you may tune up
         * the print styles (you can use !important to override styles)
         */
        @media print {
          /* Here goes your print styles */
        }

        /* Page Breaks */

        .pb_before {
           page-break-before: always !important;
        }

        .pb_after {
           page-break-after: always !important;
        }
    </style>

  </head>

  <body>

@foreach($models as $rechnung)


    <div id="container" class="pb_before pb_after">
      <section id="memo">
        <div class="logo">
          <img src="{{ public_path('img\logo250.png') }}" width="200" height="80"/>
        </div>
        
        <div class="company-info">
          <div>SchulBuchLeihe</div>
          
          <br />

          <span>Ursulaschule Osnabrück</span>

          <br />
        
          <span>Kleine Domsfreiheit 11-18</span>

          <br />

          <span>49074 Osnabrück</span>

        </div>

      </section>
      
      <div class="clearfix"></div>
      
      <section id="client-info">
        <span>
        @if($rechnung->re_anrede == 'm')
          Herrn
        @else
          Frau
        @endif
        </span>
        <div>
          <span class="client-name">{{ $rechnung->re_vorname . ' ' . $rechnung->re_nachname }}</span>
        </div>
        
        <div>
          <span>{{ $rechnung->re_strasse }}</span>
        </div>
        
        <div>
          <span>{{ $rechnung->re_plz . ' ' . $rechnung->re_ort }}</span>
        </div>

      </section>

      <section id="invoice-info">
        <div>
          <span>Datum</span>
          <span>Fälligkeit</span>
          <span>Schuljahr</span>       
          <span>Schüler-ID</span>
          <span>Rechnungs-Nr.</span>   
        </div>
        
        <div>
          <span>{{ date('d.m.Y', strtotime($rechnung->re_datum)) }}</span>
          <span>{{ date('d.m.Y', strtotime($rechnung->re_faelligkeit)) }}</span>
          <span>{{ $rechnung->s_schuljahr }}</span>
          <span>{{ $rechnung->s_id }}</span>
          <span>2019-{{ str_pad($rechnung->id, 3, '0', STR_PAD_LEFT) }}</span>
        </div>
      </section>
      
      <div class="clearfix"></div>
      
      <section id="items">
        
        <table cellpadding="0" cellspacing="0">
        
          <tr>
            <th>#</th> <!-- Dummy cell for the row number and row commands -->
            <th>Buchtitel</th>
            <th>Buch-ID</th>
            <th>Kaufpreis</th>
            <th>Leihpreis</th>
            <th>Kaufjahr</th>
            <th>Zeitwert</th>
          </tr>

          @php ($i = 1)

          @foreach($rechnung->positionen as $position)

          <tr data-iterate="item">
            <td>{{ $i++ }}</td>
            <td>{{ substr($position->titel,0,25) }}</td>
            <td>{{ $position->buch_id }}</td>
            <td>{{ number_format($position->kaufpreis, 2, ',', ' ') }} €</td>
            <td>{{ number_format($position->leihpreis, 2, ',', ' ') }} €</td>
            <td>{{ date('Y', strtotime($position->aufnahme)) }}</td>
            <td>{{ number_format($position->restwert, 2, ',', ' ') }} €</td>
          </tr>

          @endforeach

        </table>
        
      </section>

      <section id="sums">
        
        <table cellpadding="0" cellspacing="0">
          
          <tr class="amount-total">
            <th>Summe</th>
            <td>{{ number_format($rechnung->re_summe, 2, ',', ' ') }} €</td>
          </tr>
          
        </table>
        
      </section>
      
      <div class="clearfix"></div>
      
      <section id="terms">
      
        <span>
        @if($rechnung->re_anrede == 'm')
          Sehr geehrter Herr
        @else
          Sehr geehrte Frau
        @endif
        {{ $rechnung->re_nachname }},
        </span>
        
        <div>
          @if($rechnung->s_geschlecht == 'm')
            Ihrem Sohn
          @else
           Ihrer Tochter
          @endif
          <strong>{{ $rechnung->s_vorname }}</strong> sind die oben aufgeführten Lernmittel leihweise überlassen worden. Diese wurden nicht bzw. beschädigt zurückgegeben, so dass eine weitere Ausleihe nicht möglich ist. Nach den von Ihnen anerkannten Ausleihbedingungen sind Sie verplichtet, den Zeitwert der Lernmittel erstatten. (Lernmittel, deren Zeitwert 3,00&nbsp;€ oder weniger beträgt, sind nicht brücksichtigt worden.)
        </div>
        
        <div>Ich bitte Sie deshalb um die Überweisung des Betrages von&nbsp;&nbsp;<strong>{{ number_format($rechnung->re_summe, 2, ',', ' ') }} €</strong>&nbsp;&nbsp;bis zum <strong>{{ date('d.m.Y', strtotime($rechnung->re_faelligkeit)) }}</strong> auf das unten angegebene Konto. Im Betreff der Überweisung bitte unbedingt die Rechnungsnummer angeben.</div>

        <div>
        Wenn 
        @if($rechnung->s_geschlecht == 'm')
          Ihr Sohn
        @else
          Ihre Tochter
        @endif
        die neu entliehenen Lernmittel für das kommende Schuljahr abholt, besteht letztmalig die Möglichkeit, die oben aufgeführten Lernmittel zurückzugeben. Dabei setzen wir je Lernmittel pauschal eine Mahngebühr von 3,00 € an. Mahngebühren müssen in bar bezahlt werden. Diese Rechnung wird anschließend gegebenenfalls neu ausgestellt bzw. ist hinfällig.</div>

        <div>Mit freundlichen Grüßen</div>
        
        <div class="logo2">
          <img src="{{ public_path('img\HOM_176.png') }}" width="176" height="100"/> 
          <br />
          <span style="color: #888;">(Matthias Hoffmann, StD)</span>
        </div>
      </section>

      <div class="payment-info">
        <div>Bankverbindung: Ursulaschule Osnabrück - IBAN: DE02 2655 0105 0000 2036 61</div>
      </div>

    </div>

@endforeach

  </body>
</html>
