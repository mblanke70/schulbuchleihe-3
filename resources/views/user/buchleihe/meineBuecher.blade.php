@extends('adminlte::page')

@section('title', 'Meine Bücher')

@section('content_header')
    <h1>Meine Bücher</h1>
    <h4>{{ Auth::user()->vorname }} {{ Auth::user()->nachname }} ({{ Auth::user()->klasse }})</h4>
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
                        <td>{{ number_format($bw->buchtitel->leihgebuehr, 2, ',', '') }} &euro;</td>
                    </tr>
                @endforeach

            </tbody>

        </table> 
    </div>       

</div> 

@stop
