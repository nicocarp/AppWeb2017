@extends('layouts.base-create')
@section('title','Crear Promocion')
@section('navegate_tags')
  <a href="{{route('home')}}">Admin</a> |
  <a href="{{route('promociones.index')}}">Promociones</a> |  
  <a href="{{route('promociones.create')}}">Nuevo</a> |  
@endsection
@section('section_title','Crear Nueva Promocion')

@section('content_form')	


  <form method="post" action="{{route ('promociones.store')}}">
        {{ csrf_field() }}
    <div class="form-group col-md-12">
      <label for="mensaje">Mensaje</label>
      <textarea class="form-control" name="mensaje" placeholder="Mensaje" type="text">
      </textarea>
    </div>

    
    <div class="form-group col-md-6">
      <label for="cantidad">Cantidad</label>
      <input class="form-control" name="cantidad" type="number" min="0"
             placeholder="Cantidad de compras del combo" >
    </div>
    
    <div class="form-group col-md-6">
      <label for="porcentaje_descuento">Porcentaje Descuento</label>
      <input  type="number" class="form-control" min="0" max="100"
              name="porcentaje_descuento"
              placeholder="Porcentaje de Descuento del total" type="number">
    </div>

    <div class="form-group col-md-6">
      <label for="fecha_ini">Fecha Inicio</label>
      <input class="form-control datepicker inicio" name="fecha_ini"
              placeholder="Fecha de Inicio de la Promocion" type="text">
    </div>
    <div class="form-group col-md-6">
      <label cass=""for="fecha_fin">Fecha Fin</label>
      <input class="form-control datepicker fin" data-provide="datepicker" name="fecha_fin"
              placeholder="Fecha de Finalizacion de la Promocion" type="text">
    </div>

    <div class="form-group">
      <a class="btn btn-default" role="button" data-toggle="collapse" 
         href="#seleccionar_producto" aria-controls="collapseExample">
          Seleccionar Productos
      </a>
    </div>

    <div class="row">
    <div class="collapse" id="seleccionar_producto">
      <div class="well">
        @foreach($productos as $producto)
        <div class="col-md-3">
            <a class="link_tarjeta thumbnail">          
                <img class="img-thumbnail img-check"
                src="{{asset('imagenes/carp/'.$producto->ruta_imagen)}}" alt="...">
                <p class="nombre_prod nombre-prod text-center">{{$producto->nombre}}</p>
                <p class="pull-right">$ {{$producto->precio}}</p>
                <input value="{{$producto->id}}" class="check_producto"                       
                      name="id_productos[]" id="id_productos" type="checkbox">
            </a>
        </div>
      @endforeach
        <div class="clearfix "></div>
      </div>
    </div>
    </div>
    <div class="row">
      <button type="submit" class="btn btn-success pull-right">Crear Promocion</button>
      <button type="submit" class="btn btn-default pull-right">Limpiar</button>
    </div>
   </form>
  
@endsection


@section('scripts')
@parent
<script type="text/javascript">
        
        
        $('.datepicker.inicio').datepicker({
                  format: "yyyy-mm-dd",
                  startDate: 'd',
                  language: "es",
                  autoclose: true          
          });
        $('.datepicker.fin').datepicker({
                  format: "yyyy-mm-dd",
                  startDate: '+1d',
                  language: "es",
                  autoclose: true          
          });
        

        $(".link_tarjeta").click(function(){
          $(this).toggleClass("check");
          var chec = $(this).children("input");
          chec.prop("checked", !chec.prop("checked"));
        });
</script>
@endsection



