<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ValidadorStock extends Model
{
    protected $mjeError=null;
	

	public function hayStock($id_prod, $cantidad){
		$producto = Producto::find($id);
		if (!$producto){
			$this->mjeError = "Producto no existe";
			return -1;
		}
		if ( $producto->stock < $cantidad){
			$this->mjeError = "Stock insuficiente";
			return -1;
		}
		return true;
	}

	/* Decrementa stock de los productos en un carrito -> items*/
	/* Esa funcion debera hacerse con un update SQL de stock de cada producto.
		ya que de esta manera se tratarian los N decrementos como una transaccion
	*/
	public function decrementarStock($items){
		collect($items)->each(function($item){
			$item->producto->decrementarStock($item->cantidad);
		});

	}
}
