@extends('layouts.base-lista')
@section('title','Productos')
@section('navegate_tags')
	<a href="{{route('home')}}">Admin</a> |
	<a href="{{route('productos.index')}}">Productos</a> |	
@endsection

@section('section_title', 'Listado de todos los Productos')
@section('url_alta', route('productos.create'))

<div class="">
    <div class="ajaxform"><!-- loading stuff --></div>
</div>

@section('content_form_filtro')
{!! Form::open(['route' => 'productos.index', 'method' => 'GET']) !!}

    	<div class="form-group col-md-4">	
			{{ Form::text('nombre_filtro', $filtros['nombre'], ['class' => 'form-control',
	        											'placeholder'=>'Nombre']) }}
        </div>
        
        <div class="form-group col-md-4">
	       {{ Form::select('categoria_filtro', $categorias
                    , $filtros['categoria'], ['class' => 'form-control',
                    							'placeholder'=>'Categoria (todas)'
                    ]) }}
        </div>

        <div class="form-group col-md-3">
           {{ Form::text('stock_filtro', null, ['class' => 'form-control',
	        											'placeholder'=>'Stock']) }}
        </div>
        <div class="form-group col-md-1 pull-right">
			<button type="submit" class="btn btn-default" >
				<span class="glyphicon glyphicon-search"></span>
			</button>
		</div>

	{!! Form::close() !!}
@endsection
@section('content_th_table')	
	<th>#</th><th>Nombre</th><th >Precio</th><th >Stock</th><th >Categoria</th>
	<th >Accion</th>
@endsection

@section('content_tr_table')
	@foreach ($productos as $producto)
		<tr>
			<td>
				<a href="{{ route('productos.show', $producto->id) }}"
				class="btn btn-info" aria-hidden="true">
				<span class="glyphicon glyphicon-zoom-in"></span>
				</a>
			</td>
			<td>{{ $producto->nombre }}</td>
			<td>{{ $producto->precio }}</td>
			<td>{{ $producto->stock }}</td>
			<td>{{ $producto->categoria->nombre }}</td>			
			<td>
				<a href="{{ route('productos.edit', $producto->id) }}"
				class="btn btn-warning" data-method="delete" aria-hidden="true">
				<span class="glyphicon glyphicon-wrench"></span>
				</a>
				<a href="{{ route('admin.productos.destroy', $producto->id) }}"
				class="btn btn-danger" data-method="delete" aria-hidden="true">
				<span class="glyphicon glyphicon-remove-circle"></span>
			</a>
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