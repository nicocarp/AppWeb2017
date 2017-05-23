@extends('layouts.base-lista')
@section('title','Usuarios')
@section('navegate_tags')
	<a href="{{route('home')}}">Admin</a> |
	<a href="{{route('admin.usuarios.index')}}">Usuarios</a> |	
@endsection

@section('section_title', 'Listado de todos los Usuarios')


@section('content_th_table')	
	<th>#</th><th>Nombre</th><th>Email</th><th>Rol</th>
	<th >Accion</th>
@endsection

@section('content_tr_table')
	@foreach ($usuarios as $usuario)
		<tr>
			<td>
				<a href=""
				class="btn btn-info" aria-hidden="true">
				<span class="glyphicon glyphicon-zoom-in"></span>
				</a>
			</td>
			<td>{{ $usuario->name }}</td>
			<td>{{ $usuario->email }}</td>
			<td>{{ $usuario->rol }}</td>
			
			<td>
				
			</td>
		</tr>
		
	@endforeach	
@endsection


@section('scripts')

@parent
<script type="text/javascript">
	$.get('producto_json/1', function(data) {
		alert("ajax");
    	$('.modal .ajaxform').html(data);
	});
	

</script>
@endsection