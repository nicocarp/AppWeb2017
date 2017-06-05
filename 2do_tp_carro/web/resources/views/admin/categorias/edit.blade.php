@extends('layouts.base-create')
@section('title', 'Editando Categoria')
@section('navegate_tags')
	<a href="{{route('home')}}">Home</a> |
	<a href="{{route('categorias.index')}}">Categorias</a> |
	<a href="{{route('categorias.edit', $categoria->id)}}">Editar</a> |
@endsection
@section('section_title', 'Editar una Categoria')
@section('url_alta', route('categorias.create'))
@section('content_form')
	
	{!! Form::open(['route' => ['categorias.update',$categoria->id], 'method' => 'PUT']) !!}

	    <div class="form-group">
	        {{ Form::label('nombre', 'Nombre') }}
	        {{ Form::text('nombre', $categoria->nombre, ['class' => 'form-control']) }}
	    </div>

	    {!! Form::submit('Editar', ['class' => 'btn btn-primary',
	                        'data-loading-text' => "Loading...",
	                        'autocomplete' => "off",
	                        'id' => 'id_btn_submit_form'
		]) !!}
	{!! Form::close() !!}


@endsection