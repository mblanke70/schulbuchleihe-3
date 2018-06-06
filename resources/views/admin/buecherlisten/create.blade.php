@extends('adminlte::page')

@section('title', 'Bücherlisten')

@section('content_header')
    <h1>Neue Bücherliste</h1>
@stop

@section('content')

<div class="box box-primary">

    <div class="box-header with-border">
        <h3 class="box-title">Neue Bücherliste</h3>
    </div>

    <form action="{{ url('admin/buecherlisten/') }}" method="POST" role="form">
    
        {{ csrf_field() }}

        <div class="box-body">

            <div class="form-group">
                <label for="jahrgang">Jahrgang</label>
                <input type="text" class="form-control" name="jahrgang" id="jahrgang" value="" />
            </div>

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" id="name" value="" />
            </div>

            <div class="form-group">
                <label for="schuljahr">Schuljahr</label>
                <input type="text" class="form-control" name="schuljahr" id="schuljahr" value="" />
            </div>

        </div>

        <div class="box-footer">
            <button type="submit" class="btn btn-primary">Speichern</button>
        </div>

    </form>

</div>

@endsection