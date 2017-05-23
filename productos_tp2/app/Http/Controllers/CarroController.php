<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

use App\Http\Requests\StoreCarro;
use PDF;
use App\Carro;
use App\ValidadorStock;

use App\Producto;
use App\Promocion;
use App\Factura;
use App\FacturaDetalle;
use App\Venta;


class CarroController extends Controller
{
	public function index(StoreCarro $request)
    {    	
    	$promociones = Promocion::getPromosActivas();
		$carro = $request->carro->getCarroConProductos($promociones);
		return view('compras.carro',['carro' => $carro, 'promociones'=>$promociones]);
    }

    public function agregarAlCarro(StoreCarro $request)
    {
    	$id = $request->get('producto_id');
		$cantidad = $request->get('cantidad');
		$result = $request->carro->agregarAlCarro($id, $cantidad);
		
		session(['productos_en_carro' => $request->carro->getDatosGuardar() ]);
		session(['cant_productos' => $request->carro->getCantProductos() ]);
		return Redirect::route('catalogo')->with('success',"Agregado al Carro");
	}

	public function agregarComboAlCarro(StoreCarro $request, $id){
		$promo = Promocion::findOrFail($id);
		$request->carro->agregarComboAlCarro($promo);
		session(['productos_en_carro' => $request->carro->getDatosGuardar() ]);
		session(['cant_productos' => $request->carro->getCantProductos() ]);
		return Redirect::route('compras.promociones.index')->with('success',"Agregado al Carro");
	}

	public function sacarDelCarro(StoreCarro $request)
	{
		$request->carro->sacarDelCarro((int)$request->producto_id);
		session(['productos_en_carro' => $request->carro->getDatosGuardar() ]);
		session(['cant_productos' => $request->carro->getCantProductos() ]);
		return Redirect::route('compras.ver.carro')->with('success',"Producto sacado del carro");	
	}

	public function actualizarCantidad(StoreCarro $request)
	{
		$cantidades = $request->cantidades;
		$ids = $request->productos_id;
		$request->carro->actualizarCantidadesPorId($ids, $cantidades);

		session(['productos_en_carro' => $request->carro->getDatosGuardar() ]);
		session(['cant_productos' => $request->carro->getCantProductos() ]);
		return Redirect::route('compras.ver.carro')->with('success',"Actualizado");	
	}

	public function efectuar_compra(StoreCarro $request){
		if ($request->carro->estaVacio())
			return Redirect::route('compras.ver.carro')->with('error',
														'Carro esta Vacio');	
		$promociones = Promocion::getPromosActivas();
		$carro_final = $request->carro->getCarroConProductos($promociones);
		$error = "";
		DB::beginTransaction();
		try {
			$request->validador_stock->decrementarStock($carro_final->items);
			$venta = new Venta();
			$venta->efectuarVenta(Auth::user(), $carro_final->items, $carro_final->descuentos);
			DB::commit();
			$request->session()->forget('productos_en_carro');
			$request->session()->forget('cant_productos');			
		    return Redirect::route('compras.facturas.index')->with('success',
		    												'Compra Realizada Correctamente');		    
		} catch (\Exception $e) {
		    DB::rollback();		    
		    $error =$e->getMessage();
		}	
		return Redirect::route('compras.ver.carro')->with('error',$error);	 
	}	
}