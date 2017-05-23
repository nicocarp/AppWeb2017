<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
    	
        <title> Factura </title>
	</head>

<body>

	<div class="container">
		<div class="row">
			<div class="invoice-title">
    			<h2>Factura</h2><h3 class="pull-right">Nro # {{$factura->id}}</h3>
                <img src="data:image/png;base64,{{ base64_encode(QrCode::format('png')
                                                    ->size(2)
                                                    ->generate(route('compras.facturas.show', $factura->id))) }}",
                                                    style="width:50px">
    		</div>
			<p>Fecha: {{$factura->fecha}}</p>
			<p>Cliente: {{$factura->usuario->name}}</p>
        </div><hr>
        <div class="row" style="front-size:12px;">        	
            	<div class="panel panel-default">
                	<div class="panel-heading text-center">                            
                    	<h4>Detalle de la Compra</h4>
                    </div>
                    <div class="panel-body">                    	
                    	<table class="table table_factura">
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
                    					<td class="text-left">{{$detalle->producto->nombre}}</td>
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
    </div>
	
</body>

</html>