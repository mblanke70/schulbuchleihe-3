@component('mail::message')
# Liebe Eltern,

hiermit bestätigen wir Ihnen die erfolgreiche Teilnahme am Bestellverfahren der Schulbuchausleihe der Ursulaschule Osnabrück für Ihr Kind **{{$schueler->vorname }} {{ $schueler->nachname }}** für das Schuljahr 2020/21.

Die Summe der (nicht reduzierten) Leihgebühren für Bücher und E-Books beträgt zusammen **{{ number_format($summeLeihen, 2, ',', '') }} €**.

@if($leihliste->count()>0)
## Leihbücher

Die Summe der (nicht reduzierten) Leihgebühren für Bücher beträgt *{{ number_format($leihliste->sum('leihpreis'), 2, ',', '') }} €*.

@component('mail::table')
| Buchtitel     | ISBN          | Leihpreis  |
|:------------- |:------------- | ----------:|
@foreach ($leihliste as $bt)
| {{ $bt->buchtitel->titel }} | {{ $bt->buchtitel->isbn }} | {{ $bt->leihpreis }} € |
@endforeach
|               |               | *{{ number_format($leihliste->sum('leihpreis'), 2, ',', '') }}* € |
@endcomponent
@endif

@if($leihlisteEbooks->count()>0)
## E-Books

Die Summe der (nicht reduzierten) Leihgebühren für E-Books beträgt *{{ number_format($leihlisteEbooks->sum('ebook'), 2, ',', '') }} €*.

@component('mail::table')
| Buchtitel     | ISBN          | Leihpreis  |
|:------------- |:------------- | ----------:|
@foreach ($leihlisteEbooks as $bt)
| {{ $bt->buchtitel->titel }} | {{ $bt->buchtitel->isbn }} | {{ $bt->ebook }} € |
@endforeach
|               |               | *{{ number_format($leihlisteEbooks->sum('ebook'), 2, ',', '') }}* € |
@endcomponent
@endif

@if($kaufliste->count()>0)
## Kaufbücher

Die folgenden Bücher kaufen Sie sich selbst.

@component('mail::table')
| Buchtitel     | ISBN          | Kaufpreis  |
|:------------- |:------------- | ----------:|
@foreach ($kaufliste as $bt)
| {{ $bt->buchtitel->titel }} | {{ $bt->buchtitel->isbn }} | {{ number_format($bt->kaufpreis, 2, ',', '') }} € |
@endforeach
@endcomponent
@endif

Diese Übersicht finden Sie in ausführlicherer Form auf den Seiten der Schulbuchausleihe.

@component('mail::button', ['url' => 'https://sbl.ursulaschule.de'])
Link zur Schulbuchausleihe
@endcomponent

Vielen Dank für Ihre Bestellung,<br>
M. Hoffmann, M. Blanke, K. Schwegmann
@endcomponent