@extends('layouts.base-create')
@section('title', 'Show Promocion')
@section('navegate_tags')
	<a href="{{route('home')}}">Home</a> |
	<a href="{{route('promociones.index')}}">Promociones</a> |
	<a href="{{route('promociones.show', $promocion->id)}}">Detalle</a> |
@endsection
@section('section_title', 'Detalles de la Promocion')
@section('url_alta', route('promociones.create'))


@section('content_form')
			@php
				switch( $promocion->getEstado()){
					case 1: 
					    echo '<div class="alert alert-success">
						  	Esta promocion Esta Activa.
						</div>';
						$tipo_mensaje = 'success';
						break;
					case 2:
						echo '<div class="alert alert-warning">
						  	Esta promocion Estara Activa.
						</div>';						
						$tipo_mensaje='warning';
						break;
					case  0:
					 	echo '<div class="alert alert-danger">
						  	Esta promocion NO Esta Activa.
						</div>';
						$tipo_mensaje='danger';
						break;
					}					
			@endphp

	<div class="row">
		<div class="col-md-6">
	    <div class="form-group col-md-12">
	        {{ Form::label('mensaje', 'Mensaje') }}
	        {{ Form::label('mensaje', $promocion->mensaje,['class'=>'pull-right label label-'.$tipo_mensaje]) }}			
		</div>
		<div class="form-group">
	        {{ Form::label('cantidad', 'Cantidad') }}
	        {{ Form::label('cantidad', $promocion->cantidad,['class'=>'pull-right label label-'.$tipo_mensaje]) }}			
		</div>
		<div class="form-group">
	        {{ Form::label('fecha_ini', 'Fecha_ini') }}
	        {{ Form::label('fecha_ini', $promocion->fecha_ini,['class'=>'label label-'.$tipo_mensaje]) }}			
		</div>
		<div class="form-group">
	        {{ Form::label('fecha_fin', 'Fecha_fin') }}
	        {{ Form::label('', $promocion->fecha_fin,['class'=>'label label-'.$tipo_mensaje]) }}			
		</div>
		<div class="form-group">
	        {{ Form::label('porcentaje_descuento', 'Porcentaje Descuento') }}
	        {{ Form::label('', '%'. $promocion->porcentaje_descuento,['class'=>'label label-'.$tipo_mensaje]) }}			
		</div>
		</div>
		
		<div class="col-md-6">
			<div class="form-group">
				@php($subtotal = $promocion->getTotal())
				@php($descuentos = $promocion->getDescuentos())
				@php($total = $subtotal - $descuentos)
				
	        {{ Form::label('fecha_fin', 'Subtotal') }}
	        {{ Form::label('', $subtotal,['class'=>'pull-right label label-'.$tipo_mensaje,

	        								]) }}			
			</div>
			<div class="form-group">
	        {{ Form::label('fecha_fin', 'Descuentos') }}
	        {{ Form::label('', $descuentos,['class'=>'label label-'.$tipo_mensaje]) }}			
			</div>
			<div class="form-group">
	        {{ Form::label('fecha_fin', 'Total') }}
	        {{ Form::label('', $total,['class'=>'label label-'.$tipo_mensaje]) }}			
			</div>
		</div>
	</div>
		<h2>Productos de la promo</h2>
		
		
		<div class="row">

		@foreach ($promocion->productos as $producto)
	        <div class="">
	        	@include('partes.tarjeta-productos',['producto' => $producto])
	        </div>			
		@endforeach

		</div>





	    
@endsection