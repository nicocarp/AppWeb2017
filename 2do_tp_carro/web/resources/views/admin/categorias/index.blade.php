@extends('layouts.base-lista')
@section('title','Categorias')
@section('navegate_tags')
	<a href="{{route('home')}}">Admin</a> |
	<a href="{{route('categorias.index')}}">Categorias</a> |
@endsection

@section('section_title', 'Listado de todas las Categorias')
@section('url_alta', route('categorias.create'))

	@section('content_th_table')	
		<th>#</th><th>Nombre</th><th >Productos</th><th >Accion</th>
	@endsection
	
@section('content_tr_table')
	@foreach ($categorias as $categoria)
		<tr>
			<td>
				<a href="{{ route('categorias.show', $categoria->id) }}"
					class="btn btn-info" aria-hidden="true">
					<span class="glyphicon glyphicon-zoom-in"></span>
				</a>				
		</td>
			<td>{{ $categoria->nombre }}</td>
			<td>{{ $categoria->productos->count() }}</td>
			<td>
				<div class="row">
					<div class="col-md-2">
						<a href="{{ route('categorias.edit', $categoria->id) }}"
							class="btn btn-warning" data-method="delete" aria-hidden="true">
							<span class="glyphicon glyphicon-wrench"></span>
						</a>
					</div>
				<div class="col-md-2 ">
					{{ Form::open(array('route' => array('categorias.destroy', $categoria->id), 'method' => 'delete')) }}
	    				<button type="submit" class="btn btn-danger" ><span class="glyphicon glyphicon-remove-circle"></span></button>
					{{ Form::close() }}

				</div>
			</div>					
			</td>
		</tr>
	@endforeach

	
@endsection


