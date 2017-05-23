@extends('layouts.base-create')
@section('title', 'Crear Categoria')
@section('navegate_tags')
	<a href="{{route('home')}}">Home</a> |
	<a href="{{route('categorias.index')}}">Categorias</a> |
	<a href="{{route('categorias.create')}}">Nuevo</a> |	
@endsection
@section('section_title', 'Agregar Nueva Categoria')
@section('url_alta', route('categorias.create'))
	@section('content_form')

		{!! Form::open(['route' => 'categorias.store', 'method' => 'POST']) !!}

		    <div class="form-group">
		        {{ Form::label('nombre', 'Nombre') }}
		        {{ Form::text('nombre', null,array('class' => 'form-control')) }}
		    </div>
	
		    {!! Form::submit('Crear!', ['class' => 'btn btn-primary',
		                        'data-loading-text' => "Loading...",
		                        'autocomplete' => "off",
		                        'id' => 'id_btn_submit_form'
			]) !!}
	
		{!! Form::close() !!}

	@endsection


	