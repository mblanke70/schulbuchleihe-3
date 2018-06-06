@extends('adminlte::page')

@section('title', 'Bücherliste')

@section('content_header')
    <h1>Übersicht: Leihbücher und Kaufbücher</h1>
    <h3>(gewählt am: {{ $zeit }})</h3>
@stop

@section('content')



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

        <br />
        <p>Die Summe der Leihpreise beträgt {{ $summeLeihen }} &euro;.</p>
        <p>Die Summe der reduzierten Leihpreise beträgt {{ $summeLeihenReduziert }} &euro;.</p>
    </div>       

</div> 

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

<form action="{{ url('user/buchleihe/neuwahl') }}" method="POST" role="form">
    {{ csrf_field() }}
    <div>
        <button type="submit" class="btn btn-danger">Neuwahl</button>
    </div>
</form>

@stop