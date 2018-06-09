@extends('adminlte::page')

@section('title', 'Admin Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')

<div class="row">

	<div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="ion-ios-people-outline"></i></span>

            <div class="info-box-content">
            	<span class="info-box-text">Anzahl Schüler</span>
            	<span class="info-box-number">{{ $users->count() }}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>

	<div class="col-md-3 col-sm-6 col-xs-12">
	    <div class="info-box">
	       	<span class="info-box-icon bg-yellow"><i class="ion-ios-people-outline"></i></span>

	        <div class="info-box-content">
	            <span class="info-box-text">Anzahl Bücher</span>
	            <span class="info-box-number">5,000</span>
	        </div>
	        <!-- /.info-box-content -->
	    </div>
	    <!-- /.info-box -->
	</div>    

	<div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="ion-ios-people-outline"></i></span>

            <div class="info-box-content">
            	<span class="info-box-text">Gewählt</span>
            	<span class="info-box-number">{{ $users->where('fertig', 1)->count() }} </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
    
    	<div class="info-box">
        	<span class="info-box-icon bg-red"><i class="ion-ios-people-outline"></i></span>

        	<div class="info-box-content">
            	<span class="info-box-text">Nicht gewählt</span>
            	<span class="info-box-number">{{ $users->where('fertig', 0)->count() }} </span>
            </div>
            <!-- /.info-box-content -->
    	</div>
    </div>

</div>

<div class="box">

	<div class="box-header with-border">
		<h3 class="box-title">Admin Dashboard</h3>
		<div class="box-tools pull-right">
	  		<!-- Buttons, labels, and many other things can be placed here! -->
	  		<!-- Here is a label for example -->
		  	<span class="label label-primary">Label</span>
		</div>
		<!-- /.box-tools -->
	</div>
	<!-- /.box-header -->

	<div class="box-body">
		ADMIN-Home
	

	</div>

	<!-- /.box-body -->
	<div class="box-footer">
		The footer of the box
	</div>
	<!-- box-footer -->

</div>
<!-- /.box -->

@stop