@extends('adminlte::page')

@section('title', 'Leihverfahren')

@section('content_header')
    <h1>Leihverfahren: Bankeinzug (Schritt 4)</h1>
@stop

@section('content')

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="row">

    <form action="{{ url('user/buchleihe/zustimmung') }}" method="POST" role="form">

        {{ csrf_field() }}
    
        <div class="col-md-5">
            <div class="box box-solid box-danger">    
                <div class="box-header">
                    <h3 class="box-title">Bankeinzugsverfahren</h3>
                </div> 
                <div class="box-body">
                     <p>
                    Die Summe der Leihgebühren beträgt: 
                    </p>
                    <h4 style="text-align: center;">{{ number_format($summeLeihenReduziert, 2, ',', '') }} &euro;

                    @switch($ermaessigung)          
                        @case(0)
                            (Ermäßigung 100%) 
                            @break
                        
                        @case(8)
                            (Ermäßigung 20%) 
                            @break

                        @case(10)
                            (keine Ermäßigung)
                    @endswitch
                    </h4>

                    <p>
                        Dazu kommen Kosten für:
                        <ul>
                            <li>Kopiergeld (5 &euro;)</li>
                            <li>Beitrag für Eltern- und SV-Arbeit (1,50 &euro;)</li>
        
                            @if($pauschale>0)
                                <li>Nutzungsgebühr für das MS-Office Paket (6 &euro;)</li>
                                <li>Jahresbericht (4,50 &euro;)</li>
                            @endif
                        </ul>
                    </p>

                    <p>Insgesamt ergibt sich ein Betrag in Höhe von</p>
                    <h4 style="text-align: center;">{{ number_format($summeGesamt, 2, ',', '') }} &euro;</h4>

                
                    <p>Dieser Gesamtbetrag wird in diesem Jahr per Bankeinzug von dem Konto eingezogen, von dem auch vierteljährlich das Schulgeld für Ihr Kind eingezogen wird. Dafür benötigen wir eine Einverständniserklärung, die nur einmalig gilt und in jedem Jahr erneuert werden muss. Wir belasten den Betrag dem Konto, von dem auch das Schulgeld eingezogen wird.</p>
                    <p>Nach Abschluss des Leihverfahrens bleiben die Listen der gewählten Leih- und Kaufbücher weiterhin hier einsehbar.</p>

                    <div class="form-group">
                        <label for="buchleihe-zustimmung">Ich bin damit einverstanden, dass der Gesamtbetrag in Höhe von {{ number_format($summeGesamt, 2, ',', '') }}&nbsp;&euro; für das Schuljahr 2018/19 von dem Konto eingezogen wird, von dem auch das Schulgeld für mein Kind eingezogen wird.</label>
                        <input type="checkbox" id="buchleihe-zustimmung" name="zustimmung" />
                        <input type="hidden" name="betrag" value="{{ $summeGesamt }}" />
                    </div>
                </div>
            </div> 

            <div style="margin-bottom:20px;">
                <button type="submit" class="btn btn-danger">Zustimmen</button>
            </div>
        </div>

    </form>

    <div class="col-md-7">

        <div class="box box-solid box-success">    

            <div class="box-header">
                <h3 class="box-title">Leihbücher</h3>
            </div> 
            
            <div class="box-body">  

                <table id="leihen" class="table table-striped"">
                    <thead>
                        <tr>
                            <th>Titel</th> 
                            <th>ISBN</th>
                            <th>Verlag</th>
                            <th>Leihgebühr</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($leihen as $bw)
                            <tr>
                                <td scope="row">{{ $bw->buchtitel->titel }}</td>
                                <td>{{ $bw->buchtitel->isbn }}</td>
                                <td>{{ $bw->buchtitel->verlag }}</td>
                                <td>{{ $bw->buchtitel->leihgebuehr }} &euro;</td>
                            </tr>
                        @endforeach

                    </tbody>

                </table> 

                <h4>Die Summe der (nicht reduzierten) Leihpreise beträgt {{ number_format($summeLeihen, 2, ',', '') }} &euro;.</h4>

            </div>       

        </div> 

        <div class="box box-solid box-warning">    

            <div class="box-header with-border">
                <h3 class="box-title">Kaufbücher</h3>
            </div> 
            
            <div class="box-body">  

                <table id="kaufen" class="table table-striped"">
                    <thead>
                        <tr>
                            <th>Titel</th> 
                            <th>ISBN</th>
                            <th>Verlag</th>
                            <th>Preis</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($kaufen as $bw)
                            <tr>
                                <td scope="row">{{ $bw->buchtitel->titel }}</td>
                                <td>{{ $bw->buchtitel->isbn }}</td>
                                <td>{{ $bw->buchtitel->verlag }}</td>
                                <td>{{ $bw->buchtitel->preis }} &euro;</td>
                            </tr>
                        @endforeach

                    </tbody>

                </table> 
                
                <h4>Die Summe der Kaufpreise beträgt {{ number_format($summeKaufen, 2, ',', '') }} &euro;.</h4>
                <p>Die hier aufgeführten Bücher kaufen Sie sich selbst. Es findet keine Sammelbestellung von Schulseite aus statt.</p>
            </div>  

        </div>

    </div>

</div>


<div class="row">
    <div class="col-md-5"></div>
    <div class="col-md-7">

     
    </div>

</div>

@stop