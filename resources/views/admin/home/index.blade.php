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
            	<span class="info-box-number">
            		{{ $gewaehlt->count() + $nichtGewaehlt->count()}}
            	</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>

	<div class="col-md-3 col-sm-6 col-xs-12">
	    <div class="info-box">
	       	<span class="info-box-icon bg-yellow"><i class="ion-ios-book-outline"></i></span>

	        <div class="info-box-content">
	            <span class="info-box-text">Anzahl Bücher</span>
	            <span class="info-box-number">{{ $anz_buecher }}</span>
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
            	<span class="info-box-number">{{ $gewaehlt->count() }} </span>
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
            	<span class="info-box-number">{{ $nichtGewaehlt->count() }} </span>
            </div>
            <!-- /.info-box-content -->
    	</div>
    </div>

</div>

<div class="row">
	<div class="col-md-6">
		<div class="box">

			<div class="box-header with-border">
				<h3 class="box-title">Zuletzt Gewählt</h3>
				<div class="box-tools pull-right">
			  		<!-- Buttons, labels, and many other things can be placed here! -->
				</div>
				<!-- /.box-tools -->
			</div>
			<!-- /.box-header -->

			<div class="box-body">
				
				<div class="table-responsive">

                    <table id="gewaehlt" class="display compact" cellspacing="0" width="100%">

                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Vorname</th>
                                <th>Klasse</th> 
                                <th>Zeit</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($gewaehlt as $s)

                                <tr>
                                    <td>{{ $s->nachname }}</td>
                                    <td>{{ $s->vorname }}</td>
                                    <td>{{ $s->klasse }}</td>
                                    <td>{{ $s->updated_at }}</td>
                                </tr>

                            @endforeach
                        
                        </tbody>

                    </table>

                </div>

			</div>

		</div>
		<!-- /.box -->
	</div>

	<div class="col-md-6">
		<div class="box">

			<div class="box-header with-border">
				<h3 class="box-title">Noch nicht gewählt</h3>
				<div class="box-tools pull-right">
			  		<!-- Buttons, labels, and many other things can be placed here! -->
				</div>
				<!-- /.box-tools -->
			</div>
			<!-- /.box-header -->

			<div class="box-body">
				
				<div class="table-responsive">

                    <table id="nichtGewaehlt" class="display compact" cellspacing="0" width="100%">

                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Vorname</th>
                                <th>Klasse</th> 
                            </tr>
                        </thead>


                        <tbody>

                            @foreach ($nichtGewaehlt as $s)

                                <tr>
                                    <td>{{ $s->nachname }}</td>
                                    <td>{{ $s->vorname }}</td>
                                    <td>{{ $s->klasse }}</td>
                                </tr>

                            @endforeach
                        
                        </tbody>
                    </table>

                </div>

			</div>
		</div>
		<!-- /.box -->
	</div>

</div>

@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#gewaehlt').DataTable( {
                order: [[ 3, "desc" ]]
            });

            $('#nichtGewaehlt').DataTable( {
                order: [[ 2, "asc" ]]
                //processing: true,
                //serverSide: true,
                //ajax: "{{ url('admin/getIndexData') }}",
                //columns: [
                //    { data: 'id', name: 'id'},
                //    { data: 'nachname', name: 'nachname' },
                //    { data: 'vorname', name: 'vorname' },
                //    { data: 'klasse', name: 'klasse' }
                //],
                //dom: 'Bfrtip',
                //buttons: ['print'],
            });

           
        });
    </script>
@stop