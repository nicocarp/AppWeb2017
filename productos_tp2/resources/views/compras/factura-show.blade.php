@extends('layouts.base')
@section('title', 'Factura '. $factura->id)
@section('navegate_tags')
	<a href="{{route('home')}}">Home</a> |
	<a href="{{route('compras.facturas.index')}}">Facturas</a> |
	<a href="{{route('compras.facturas.show', $factura->id)}}">{{$factura->id}}</a> |
	<a href="{{route('compras.facturas.show.pdf', $factura->id)}}">Factura PDF</a> |
	
@endsection
@section('section_title', 'Detalles de la Compra')
@section('url_alta', route('productos.create'))

@section('content')
	<div class="row">
		<p>Fecha: {{$factura->fecha}}</p>
		<p>Cliente: {{$factura->usuario->name}}</p>			
	</div>        
    <div class="row" style="front-size:12px;">        	
    	<div class="panel panel-default">
        	<div class="panel-body">                    	
            	<table class="table table-responsive ">
            		<thead>
            			<tr>
            				<th>Producto</th>
            				<th>Cantidad</th>
            				<th>Precio u</th>
            				<th>Total</th>
            			</tr>
            		</thead>
            		<tbody>
            			@foreach ($factura->facturaDetalles as $detalle)
            				<tr>
            					<td class="text-left">
            						<a data-toggle="modal" data-target="#exampleModal" 
        		data-ruta-detalle="{{ route('compras.detalle.producto', $detalle->producto->id) }}"
           					class="btn_info_carro" role="button">{{$detalle->producto->nombre}}
								</td>
									<td class="text-center">{{$detalle->cantidad}}</td>
            					<td class="text-center">$ {{$detalle->precio}}</td>
            					<td class="text-right">$ {{$detalle->precio * $detalle->cantidad }}</td>
            				</tr>		                    		
                    	@endforeach
                    	<tr style="border-top: 2px solid;">
                    		<td></td>
                    		<td></td>
                    		<td class="text-center"><strong>Total</strong></td>
                                @php ($_total = $factura->getPrecioSinDescuento())
                    		<td class="text-right">$ {{$_total}}</td>
                    	</tr>
                    	<tr>
                    		<td></td>
                    		<td></td>
                    		<td class="text-center"><strong>Descuentos</strong></td>
                    		<td class="text-right">$ {{$factura->descuentos}}</td>		                    		
                    	</tr>
                    	<tr>
                    		<td></td>
                    		<td></td>
                    		<td class="text-center"><strong>Total</strong></td>
                    		<td class="text-right">$ {{ $_total- $factura->descuentos}}</td>
                    	</tr>
            		</tbody>
            	</table>                    	
            </div>                    
		</div>            
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

