
@extends('layouts.base')
@section('title','Carrito')
@section('section_title','Carrito de Compras')
@section('content')	

@if ($carro->items == [])
	<h1 class="text-center">Carrito Vacio</h1>
@else
<div class="row">
@foreach($carro->items as $item)
	
	<div class="col-md-12">
		<div class="col-md-2">
			<img class="img-thumbnail img-check"
			src="{{asset('imagenes/carp/'.$item->producto->ruta_imagen)}}" alt="...">
		</div>
		<div class="col-md-4">
			<p>{{$item->producto->nombre}}</p>			
			<p>{{$item->producto->stock}}</p>
		</div>
		<div class="form-group col-md-2">
			<input data-prod-id="{{$item->producto->id}}" type="number" 
					data-url="{{route('compras.actualizar.cantidad.carro')}}"
					class="form-control cantidades" value="{{$item->cantidad}}">			
		</div>
		<div class="col-md-3 text-center">
			<p>${{ $item->producto->precio * $item->cantidad}}</p>
			<span><p>c/u ${{$item->producto->precio}}</p></span>
		</div>	
		<div class="col-md-1">
			{{ Form::open(array('route' => array('compras.sacar.carro'), 'method' => 'delete')) }}
	    		<input name="producto_id" hidden value="{{$item->producto->id}}">
	    		<button class="btn btn-default" type="submit" aria-hidden="true">
					<span class="glyphicon glyphicon-remove"></span>
				</button>
			{{ Form::close() }}			
		</div>
		<input value="{{$item->producto->id}}" hidden class="_productos" name="id_productos[]" >
		<input value="{{$item->cantidad}}" hidden class="_cantidades" name="id_productos[]" >
	</div>	
@endforeach
</div>
<br>
<div class="row text-center">
	<div class="col-md-6">
		<strong>Subtotal</strong>
	</div>	
	<div class="col-md-6">
		<strong>$ {{$carro->precioTotalSinDescuento}}</strong>
	</div>
	
	<div class="col-md-6">
		<strong>Descuentos</strong>
	</div>
	<div class="col-md-6">
		<strong>$ {{$carro->descuentos}}</strong>
	</div>
	
	<div class="col-md-6">
		<strong>Total</strong>
	</div>
	
	<div class="col-md-6">
		<strong>$ {{$carro->precioTotalConDescuento}}</strong>
	</div>
</div>
<br>
<div class="row">
	<div class="form-group pull-right">
		<a class="btn btn-success" href="{{route('compras.efecutar.compra')}}">Comprar</a>
	</div>
	<div class="form-group pull-right">
		{{ Form::open(array('route' => array('compras.actualizar.cantidad.carro'), 
							'method' => 'PUT',
							'id'=>'form-update')) }}		
			<button id="btn_actualizar" class="btn btn-default" href="">Actualizar</button>
					{{ Form::close() }}		
	</div>
</div>
@endif

@endsection

@section('scripts')
@parent
<script type="text/javascript">
//{{route('compras.actualizar.cantidad.carro')}}
	$("#btn_actualizar").prop('disabled',true);
	$("form").submit(function() {
		$('.cantidades').each(function(i, input){
			id_prod = $(input).data('prodId');;
			cantidad = $(input).val();
			var input = document.createElement('input');
		    input.type = 'hidden';
		    input.name = "cantidades[]";
		    input.value = cantidad;
		    console.log(input);
		    $("#form-update").append(input);
		    var input = document.createElement('input');
		    input.type = 'hidden';
		    input.name = "productos_id[]";
		    input.value = id_prod;
		    $("#form-update").append(input);
		})
		return true;
	});


	$('.cantidades').change(function(){
		$("#btn_actualizar").prop('disabled',false);
		/*url = $(this).data('url');
		$.post( url, { 
			 "_token": "{{ csrf_token() }}",
			cantidad: $(this).val(),  id_prod: $(this).data('prodId') },function(data){
				alert(data);
			} );*/

	})
</script>


@endsection



