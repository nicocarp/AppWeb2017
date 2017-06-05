<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;



class Carro extends Model
{
	protected $productos = [];
	protected $validador = null;
	
	public $items=[];
	public $precioTotalSinDescuento = 0;
	public $precioTotalConDescuento = 0;
	public $descuentos = 0;
	public $cantidadProductos = 0;
	
    public function __construct($productos, $validador){
    	$this->productos = $productos;
    	$this->validador = $validador;
	}

	public function estaVacio(){

		return (!isset($this->productos) || sizeof($this->productos) == 0);
	}

	private function getDescuentos($promociones){
		if ($this->productos == null || $promociones->isEmpty())
			return 0;
		$mis_productos = $this->productos;
		return $promociones->reduce(function($acum, $promo) use ($mis_productos){
			return $acum + $promo->getDescuentosEnCarro($this->productos);
		});
	}

	public function agregarComboAlCarro($promocion){
		$cantidad = $promocion->cantidad;
		$promocion->productos->each(function($producto) use ($cantidad){
			if (isset($this->productos[$producto->id]))
				$this->productos[$producto->id] += $cantidad; 
			else
				$this->productos[$producto->id] = $cantidad; 
		});
	}
    public function agregarAlCarro($id, $cantidad){
    	$cantidad = (int)$cantidad;
    	if (isset($this->productos[$id]))
    		$this->productos[$id] += $cantidad;    		
    	else
    		$this->productos[$id] = $cantidad;    	
    }

    public function sacarDelCarro($id){
    	if (isset($this->productos[$id]))
			unset($this->productos[$id]);
    }
    
    public function getCantPorId($id){
    	if (isset($this->productos[$id]))
    		return $this->productos[$id];
    	return -1;
	}

	public function actualizarCantidadesPorId($ids, $cantidades){
		if (sizeof($ids) != sizeof($cantidades)){
			return;
		}
		for ($i=0; $i<sizeof($ids); $i++){
			if (isset($this->productos[$ids[$i]]))
				$this->productos[$ids[$i]] = (int)$cantidades[$i];			
		}
		
	}

	/* Funciona necesaria para manter en nav la cantidad de productos en el carrito*/
	public function getCantProductos(){
		$cant = 0;
		foreach ($this->productos as $key => $value){
			$cant += $value;
		}
		return $cant;
	}

	/* Devolvemos los datos que se deben guardar en la sesion*/
	public function getDatosGuardar(){
		return $this->productos;
	}

	/*Devuelvo instancia de carro para mostrar en la vista. Todos los datos calculados.*/
	public function getCarroConProductos($promociones){
		$cantidad_productos = 0;
		$datos = [];
		$precio_total = 0;
		if ($this->productos != null){
			foreach ($this->productos as $id_prod => $cantidad){
				$producto = Producto::find($id_prod);
				array_push($datos, (object)["producto"=>$producto,"cantidad"=>$cantidad]);			
				$cantidad_productos += $cantidad;
				$precio_total += $producto->precio * $cantidad;
			}
		}
		$this->items = $datos;
		$this->descuentos = $this->getDescuentos($promociones);
		$this->precioTotalSinDescuento = $precio_total;
		$this->precioTotalConDescuento = $this->precioTotalSinDescuento - $this->descuentos;
		$this->cantidadProductos = $cantidad_productos;
		return $this;
	}
}
