@extends('layouts.base-create')
@section('title', 'Show Categoria')
@section('navegate_tags')
	<a href="{{route('home')}}">Home</a> |
	<a href="{{route('categorias.index')}}">Categorias</a> |
	<a href="{{route('categorias.show', $categoria->id)}}">Detalle</a> |
@endsection
@section('section_title', 'Detalles de la Categoria')
@section('url_alta', route('categorias.create'))


@section('content_form')
	    <div class="form-group">
	        {{ Form::label('_nombre', 'Nombre') }}
	        {{ Form::label('nombre', $categoria->nombre,['class'=>'label label-success']) }}			
		</div>
		@foreach ($productos as $producto)
			{{$producto->nombre}}
		@endforeach

	    
@endsection