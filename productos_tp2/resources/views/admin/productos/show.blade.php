@extends('layouts.base-create')
@section('title', 'Show Producto')
@section('navegate_tags')
	<a href="{{route('home')}}">Home</a> |
	<a href="{{route('productos.index')}}">Productos</a> |
	<a href="{{route('productos.show', $producto->id)}}">Detalle</a> |
@endsection
@section('section_title', 'Detalles del Producto')
@section('url_alta', route('productos.create'))

@section('content_form')

<div class="row">
	<div class="col-md-6">
		{{ Html::image('imagenes/carp/'.$producto->ruta_imagen,null,
            	['alt'=>"profile Pic",'']) }}
	</div>
	<div class="col-md-6">
		<div class="form-group">
	        {{ Form::label('_nombre', 'Nombre') }}
	        {{ Form::label('nombre', $producto->nombre,['class'=>'label label-success']) }}
		</div>

	    <div class="form-group">
	    	{{ Form::label('descripcion', 'Descripcion') }}
	        {{ Form::label('descripcion', $producto->descripcion) }}	        
	    </div>

	    <div class="form-group">
	    	{{ Form::label('precio', 'Precio') }}
	        {{ Form::label('precio','$'.$producto->precio,['class'=>'label label-warning']) }}
	        
	    </div>

	    <div class="form-group">
	    	{{ Form::label('stock', 'Stock') }}
	        {{ Form::label('stock', $producto->stock, ['class'=>'label label-warning']) }}
	    </div>    

	    <div class="form-group">
            {{ Form::label('categoria', 'Categoria') }}
            {{ Form::label('categoria_id', $producto->categoria->nombre,['class'=>'label label-warning']) }}
        </div>

	</div>
</div>
@endsection