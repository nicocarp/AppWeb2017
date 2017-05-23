@extends('layouts.base')
@section('title', 'Promociones del dia ')
@section('navegate_tags')
	<a href="{{route('home')}}">Home</a> |
	<a href="{{route('catalogo')}}">Catalogo</a> |
	<a href="{{route('compras.promociones.index')}}">Promociones</a> |	
	
@endsection
@section('section_title', 'Promociones del Dia')
@section('content')
	                    	
	@foreach ($promociones as $promocion)
        <div class="row">
        <div class="col-md-6 pull-right">
            <p>Mensjae: {{$promocion->mensaje}}</p>    
            <p>Descuento: %{{$promocion->porcentaje_descuento}}</p>    
            <p>Cantidad: {{$promocion->cantidad}}</p>    
            <form method='get' action="{{route('compras.add.carro.combo', $promocion->id)}}" id="form-add-promo"> 
                <button data-promo-id="{{$promocion->id}}"  id="btn-submit-promo"
                    class="btn btn-success pull-right" >Agregar</button>    
            </form>            
        </div>        
        <div class="col-md-6">
            @foreach ($promocion->productos as $producto)       
                <a class="link_tarjeta thumbnail">   
                <div class="row">
                    <div class="col-md-3">
                        <img class="img-thumbnail img-check"
                        src="{{asset('imagenes/carp/'.$producto->ruta_imagen)}}" alt="...">
                    </div>
                        <p class="nombre_prod">{{$producto->nombre}}</p>                        
                        <p class="">$ {{$producto->precio}}</p>                   
                </div>  
                </a>                
            @endforeach
        </div>            
        <hr><hr><br><br><br><br>
        
        </div>
	@endforeach
         
     
@endsection

@include('partes.modal')

@section('scripts')
@parent
<script type="text/javascript">
  $('#myModal').modal();
  /*Pidiendo detalles del producto */

  $('#btn-submit-promo').click(function(){
    var promo_id = $(this).data('promoId');
    var input = document.createElement('input');
    input.type = 'hidden';
    input.name = "promocion_id";
    input.value = promo_id;
    $("#form-add-promo").append(input);
    return true;
  });
  $(".btn_info_carro").click(function(){
    ruta_detalle_prod = $(this).data('rutaDetalle');
    $( "#contenido_info_producto" ).load(ruta_detalle_prod);
  });
  
  $("#btn_add_carro").click(function(){
    $("#form_add_carro").submit();    
  });
</script>

@endsection

