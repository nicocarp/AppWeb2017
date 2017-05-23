@extends('layouts.base')
@section('title','Catalogo de Productos')
@section('section_title','Catalogo de Productos')
@section('content')	


<div class="row">
@foreach($productos as $producto)

  <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img src="{{asset('imagenes/carp/'.$producto->ruta_imagen)}}" alt="...">
      <div class="caption">
        <p class="nombre_prod text-center">{{$producto->nombre}}</p>
        <p class="pull-right">$ {{$producto->precio}}</p>
      </div>  
        <p><a href="#" class="btn btn-primary" role="button">Comprar</a></p> 
    </div>
  </div>

@endforeach
</div>

  
  
@endsection
@section('scripts')
@parent
<script type="text/javascript">


</script>

@endsection



