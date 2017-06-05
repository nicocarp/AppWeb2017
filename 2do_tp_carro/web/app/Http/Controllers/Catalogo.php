<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;
use App\Producto;
use App\Promocion;

class Catalogo extends Controller
{
    public function index()
    {
        $categorias = Categoria::all();
        $productos= Producto::all();

        return View('compras.catalogo', [
                                    'categorias'=>$categorias,
                                    'productos'=>$productos
                                    ]);
    }
    public function promociones(Request $request){
    	$promos_activas = Promocion::getPromosActivas(date('Y-m-d'));
    	return view('compras.promociones-index',['promociones'=>$promos_activas]);
    	
    }
}
