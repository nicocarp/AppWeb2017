@extends('layouts.base')
@section('title','Catalogo de Productos')
@section('section_title','Catalogo de Productos')
@section('content')	

<div class="row">
@foreach($productos as $producto)
  <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <a data-toggle="modal" data-target="#exampleModal" 
            data-ruta-detalle="{{ route('compras.detalle.producto', $producto->id) }}"
               class="btn_info_carro" role="button">
        <img src="{{asset('imagenes/carp/'.$producto->ruta_imagen)}}" alt="...">
        <div class="caption">
          <p class="nombre_prod text-center nombre-prod">{{$producto->nombre}}</p>
          <p class="text-center">$ {{$producto->precio}}</p>
        </div> 
      </a>
    </div>
  </div>
@endforeach
</div>

  
@endsection
@include('partes.modal')

@section('scripts')
@parent
<script type="text/javascript">
  $('#myModal').modal();
  /*Pidiendo detalles del producto */

  $(".btn_info_carro").click(function(){
    ruta_detalle_prod = $(this).data('rutaDetalle');
    $( "#contenido_info_producto" ).load(ruta_detalle_prod);
  });
  
  $("#btn_add_carro").click(function(){
    $("#form_add_carro").submit();    
  });
</script>

@endsection



