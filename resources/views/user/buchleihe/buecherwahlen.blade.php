@extends('adminlte::page')

@section('title', 'Bücherliste')

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
                    Die Summe der Leihgebühren beträgt: {{ $summeLeihen }} &euro;

                    @switch($ermaessigung)          
                        @case(0)
                            <br /> - Ermäßigung (100%) = 0 &euro; 

                            @break
                        
                        @case(8)
                            <br /> - Ermäßigung (20%) = {{ $summeLeihenReduziert }} &euro; 

                            @break
                    @endswitch

                    <br /> + Kopiergeld (5 &euro;) = {{ $summeLeihenReduziert + 5 }} &euro;

                    @if($pauschale>0)
                        <br /> + MS-Office Paket (6 &euro;) =  {{ $summeLeihenReduziert + $pauschale + 5 }} &euro;
                    @endif
                    </p>

                    <p>Die Leihgebühren, das Kopiergeld sowie ggf. die jährlichen Kosten für das MS-Office-Paket werden in diesem Jahr per Bankeinzug von dem Konto eingezogen, von dem auch das jährliche Schulgeld für Ihr Kind eingezogen wird. Dafür benötigen wir Ihre Zustimmung. Erst mit dieser Zustimmung ist das Leihverfahren abgeschlossen.</p>
                    <p>Nach Abschluss des Leihverfahrens bleiben die Listen der gewählten Leih- und Kaufbücher weiterhin hier einsehbar.</p>


                    <div class="form-group">
                        <label for="buchleihe-zustimmung">Ich bin einverstanden, dass der Gesamtbetrag in Höhe von {{ $summeLeihenReduziert + $pauschale + 5 }}&nbsp;&euro; von dem Konto eingezogen wird, von dem auch das Schulgeld für mein Kind eingezogen wird.</label>
                        <input type="checkbox" id="buchleihe-zustimmung" name="zustimmung" />
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

            </div>       

        </div> 
    </div>

</div>


<div class="row">
    <div class="col-md-5"></div>
    <div class="col-md-7">

        <div class="box box-solid box-warning">    

            <div class="box-header with-border">
                <h3 class="box-title">Kaufbücher</h3>
                <p>Die hier aufgeführten Bücher kaufen Sie sich selbst. Es findet keine Sammelbestellung von Schulseite aus statt.</p>
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
                <br />
                <p>Die Summe der Kaufpreise beträgt {{ $summeKaufen }} &euro;.</p>
            </div>  

        </div>

    </div>

</div>

@stop