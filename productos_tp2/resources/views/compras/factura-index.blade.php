@extends('layouts.base-lista')
@section('title','Mis Compras')
@section('navegate_tags')
	<a href="{{route('home')}}">Home</a> |
	<a href="{{route('compras.facturas.index')}}">Facturas</a> |	
@endsection

@section('section_title', 'Listado de todas mis Compras')
@section('url_alta', route('productos.create'))


@if ($facturas == [])
	<h2>Listado Vacio</h2>
@else
	@section('content_th_table')	
		<th>#</th><th>Fecha</th><th>Total</th><th>Cant Productos</th>	
	@endsection

	@section('content_tr_table')
		@foreach ($facturas as $factura)
			<tr>
				<td>
					<a href="{{route('compras.facturas.show', $factura->id)}}"
					class="btn btn-info" aria-hidden="true">
					<span class="glyphicon glyphicon-zoom-in"></span>
					</a>
				</td>
				<td>{{ $factura->fecha }}</td>
				<td>$ {{ $factura->getPrecioSinDescuento() - $factura->descuentos}}</td>			
				<td>{{ $factura->getCantProductos()}}</td>			
			</tr>
		@endforeach			
	@endsection
@endif