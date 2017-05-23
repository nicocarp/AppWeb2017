<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;
use App\Producto;
use App\Promocion;
use Carbon\Carbon;
use App\Http\Requests\StorePromocion;


class PromocionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $promos = Promocion::all();        
        return view('admin.promociones.index', [
                'promociones' => $promos
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorias = Categoria::all();
        #$productos = Promocion::getProductosSinPromo();
        $productos = Producto::all();

        return View('admin.promociones.create', [
                                    'categorias'=>$categorias,
                                    'productos'=>$productos
                                    ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePromocion $request)
    {        

        $promo = new Promocion($request->all());
        $ids_productos = $request->id_productos;
        $promo->save();
        foreach ($ids_productos as $id_prod){
            $producto = Producto::findOrFail($id_prod);
            $promo->productos()->save($producto);
        }
        $mje="Promocion creada Correctamente";
        return redirect()->route('promociones.index')->with('success',$mje);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $promocion = Promocion::findOrFail($id);
        return view('admin.promociones.show')->with('promocion',$promocion);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $promo = Promocion::findOrFail($id);
        $promo->fecha_fin = Date('Y-m-d');
        $promo->save();
        $mje = 'Promocion ha sido dada de baja correctamente';
        return redirect()->route('promociones.index')->with('success',$mje);        
    }
}
