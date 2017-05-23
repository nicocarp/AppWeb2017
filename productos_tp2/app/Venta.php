<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    // Recibe carro  y un usuario y crea factura asociada
    public function efectuarVenta($usuario, $items, $descuentos = 0){
    	
    	$detalles = [];
		$factura = new Factura();
		$factura->usuario()->associate($usuario);
		$factura->fecha = date('Y-m-d');
		$factura->descuentos = $descuentos;
		$factura->save();

		$detalles = collect($items)->map(function($item){
			$detalle = new FacturaDetalle();
			$detalle->cantidad = $item->cantidad;
			$detalle->precio = $item->producto->precio;
			$detalle->producto()->associate($item->producto);
			//$detalle->producto_id = $item->producto->id;
			return $detalle;
		});		
		$factura->facturaDetalles()->saveMany($detalles);
	}
}
