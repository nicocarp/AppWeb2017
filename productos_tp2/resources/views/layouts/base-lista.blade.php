@extends('layouts.base')
@section('content')
	@yield('content_form_filtro')

	<table class="table table-bordered table-responsive text-center"> 
		<thead>
			@yield('content_th_table')
		</thead>
		<tbody>
			@yield('content_tr_table')
		</tbody>		
	</table>
@endsection


