@extends('adminlte::page')

@section('title', 'Abfrage-Antworten')

@section('content_header')
    <h1>Abfrage-Antworten</h1>
@stop

@section('content')
 
<div class="row">

    <div class="col-md-6">
        <div class="box">

            <div class="box-header with-border">
                <h3 class="box-title">Abfrage</h3>
            </div>

            <table class="table">

                <tr>
                    <th>ID</th>
                    <td> {{ $abfrage->id }} </td>
                </tr>
                <tr>
                    <th>Jahrgang</th>
                    <td> {{ $abfrage->jahrgang }} </td>
                </tr>
                <tr>
                    <th>Titel</th>
                    <td> {{ $abfrage->titel }} </td>
                </tr>
                <tr>
                    <th>Parent ID</th>
                    <td> {{ $abfrage->parent_id }} </td>
                </tr>
                <tr>
                    <th>Child ID</th>
                    <td> {{ $abfrage->child_id }} </td>
                </tr>
            
            </table>
        </div>
    </div>

    <div class="col-md-6">
        <div class="box">

            <div class="box-header with-border">
                <h3 class="box-title">Neue Antwort</h3>
            </div>

            <form action="{{ url('admin/abfragen/attach', [$abfrage->id]) }}" method="POST" role="form">

                {{ csrf_field() }}

                <div class="box-body">

                    <div class="form-group">
                        <label for="antwort-titel">Titel</label>
                        <input type="text" class="form-control" name="titel" id="antwort-titel" placeholder="Titel" />
                    </div>
                    @if (isset($abfrage->parent_id))
                    <div class="form-group">
                        <label for="antwort-wert">Buchgruppe</label>
                        <select name="wert" class="form-control" id="antwort-buch">
                            <option value="">keine</option>
                        @foreach ($buchgruppen as $bg)
                            <option value="{{ $bg->id }}">{{ $bg->fach->name }} {{ $bg->bezeichnung }}</option>
                        @endforeach
                        </select>
                    </div>
                    @else
                    <div class="form-group">
                        <label for="antwort-wert">Fach</label>
                        <select name="wert" class="form-control" id="antwort-buch">
                            <option value="">Nicht belegt</option>
                        @foreach ($faecher as $f)
                            <option value="{{ $f->id }}">{{ $f->name }}</option>
                        @endforeach
                        </select>
                    </div>
                    @endif
                    
                </div>
                
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Neue Antwort hinzufügen</button>
                </div>
            </form>
    
        </div>
    </div>

    
</div>    

<hr />

<div class="box">

    <div class="box-header with-border">
        <h3 class="box-title">Antworten</h3>
    </div>

    <div class="box-body">    
        <table id="antworten" class="display" cellspacing="0" width="100%">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Abfrage-ID</th> 
                    <th>Titel</th>
                    <th>Wert</th>
                    <th>Next-ID</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($antworten as $antw)

                    <tr>
                        <td> {{ $antw->id }} </td>
                        <td> {{ $antw->abfrage_id }} </td>
                        <td> {{ $antw->titel }} </td>
                        <td> {{ $antw->wert }} </td>
                        <td> {{ $antw->next_id }} </td>
                    </tr>

                @endforeach
            
            </tbody>

        </table>  
        
    </div>
</div>

@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#antworten').DataTable();
        } );
    </script>
@stop