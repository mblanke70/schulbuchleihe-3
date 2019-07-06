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
        @font-face {
          font-family: PT+Sans;
          src: url('PT_Sans-Web-Regular.ttf');
        }

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
          font: normal 14px/1.5em 'PT Sans', Sans-serif;
          margin: 0 auto;
          padding: 60px;
          min-height: 1038px;
        }

        #memo .logo {
          float: left;
          margin-right: 20px;
        }
        #memo .logo img {
          width: 150px;
          height: 100px;
        }
        #memo .company-info {
          float: right;
          text-align: right;
        }
        #memo .company-info > div:first-child {
          display: inline-block;
          line-height: 1em;
          font-weight: bold;
          font-size: 40px;
          margin-bottom: 10px;
        }
        #memo .company-info span {
          font-size: 12px;
          display: inline-block;
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
          margin-top: 50px;
        }
        #invoice-title-number span {
          margin-right: 10px;
          display: inline-block;
          min-width: 20px;
        }
        #invoice-title-number #title {
          text-align: right;
          font-size: 28px;
          font-weight: bold;
        }
        #invoice-title-number #number {
          font-size: 14px;
          color: #888;
          text-align: left;
        }

        #client-info {
          float: left;
          margin-top: 30px;
          min-width: 220px;
        }
        #client-info > div {
          margin-bottom: 3px;
          min-width: 20px;
        }
        #client-info .client-name {
          font-weight: bold;
          font-size: 15px;
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
          margin-top: 85px;
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
          margin-top: 40px;
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
          margin: 70px 0 20px 0;
          page-break-inside: avoid;
        }
        #terms > span {
          display: inline-block;
          min-width: 20px;
          font-weight: bold;
        }
        #terms > div {
          margin-top: 10px;
          min-height: 50px;
          min-width: 50px;
        }

        .payment-info div {
          color: #888;
          font-size: 12px;
          display: inline-block;
          min-width: 20px;
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

@foreach($rechnungen as $schueler)

    <div id="container" class="pb_before pb_after">
      <section id="memo">
        <div class="logo">
          <img src="ursula_logo.png" />
        </div>
        
        <div class="company-info">
          <div>Ursulaschule Osnabrück</div>

          <br />
          
          <span>Kleine Domsfreiheit 11-18</span>
          <span>49074 Osnabrück</span>

          <br />

          <span>Tel. 0541-318701</span>
          <span>sbl@ursulaschule.de</span>
        </div>

      </section>

      <section id="invoice-title-number">
      
        <span id="title">Rechnung</span>
        <span id="number">2019-001</span>
        
      </section>
      
      <div class="clearfix"></div>
      
      <section id="client-info">
        <span>An</span>
        <div>
          <span class="client-name">{{ $schueler->get('vorname') . ' ' . $schueler->get('nachname') }}</span>
        </div>
        
        <div>
          <span>{client_address}</span>
        </div>
        
        <div>
          <span>{client_city_zip_state}</span>
        </div>

      </section>

      <section id="invoice-info">
        <div>
          <span>Datum</span>
          <span>{net_term_label}</span>
          <span>Fälligkeit</span>
          <span>{po_number_label}</span>
        </div>
        
        <div>
          <span>{{ date('d.m.Y') }}</span>
          <span>{net_term}</span>
          <span>{{ date('d.m.Y', strtotime("+30 days")) }}</span>
          <span>{po_number}</span>
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
            <th>Restwert</th>
          </tr>

          @php ($i = 1)

          @foreach($schueler->get('buecher') as $buch)

          <tr data-iterate="item">
            <td>{{ $i++ }}</td>
            <td>{{ $buch->get('titel') }}</td>
            <td>{{ $buch->get('id') }}</td>
            <td>
              @if($buch->get('schuljahr') < 3)
                *&nbsp;
              @endif
              {{ $buch->get('kaufpreis') }}€
            </td>
            <td>{{ $buch->get('leihpreis') }}€</td>
            <td>{{ $buch->get('jahr') }}</td>
            <td>{{ $buch->get('restwert') }}€</td>
          </tr>

          @endforeach

        </table>
        
      </section>

      <section id="sums">
        
        <table cellpadding="0" cellspacing="0">
          
          <tr class="amount-total">
            <th>Summe</th>
            <td>{{ $schueler->get('summe') }}€</td>
          </tr>
          
        </table>
        
      </section>
      
      <div class="clearfix"></div>
      
      <section id="terms">
      
        <span>Sehr geehrte Fam. {{ $schueler->get('nachname') }},</span>
        <div>Ihnen wurden die oben genannten Lernmittel leihweise überlassen. Diese wurden nicht bzw. beschädigt zurückgegeben, so dass eine weitere Ausleihe nicht möglich ist. Nach den von Ihnen anerkannten Ausleihbedingungen sind Sie verplichtet, den Zeitwert des Lernmittels erstatten.</div>
        <div>Ich bitte Sie deshalb um Überweisung des Betrages von <strong>{{ $schueler->get('summe') }}€</strong> bis zum <strong>{{ date('d.m.Y', strtotime("+30 days")) }}</strong> auf das folgende Konto:</div>
        <pre>
  Ursulaschule Osnabrück
  IBAN: DE02 2655 0105 0000 2036 61
  BIC:  NOLADE22XXX
  Sparkasse Osnabrück
        </pre>
        <div>Im Betreff der Überweisung bitte unbedingt den Name der bzw. des Ersatzpflichtigen angeben.</div>
        <div>Mit freundlichen Grüßen</div>
        
      </section>

      <div class="payment-info">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
      </div>
    </div>

@endforeach

  </body>
</html>
