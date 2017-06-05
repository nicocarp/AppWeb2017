<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;
use App\Categoria;
use App\Http\Requests\StoreProducto;

class ProductosController extends Controller
{
    public function __construct(Request $request) {

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $filtros = [];
        $filtros["categoria"] = $request->get('categoria_filtro');
        $filtros["nombre"] = $request->get('nombre_filtro');  
        $productos = Producto::nombre($filtros["nombre"])->categoria($filtros["categoria"])->get();
        $categoiras = Categoria::pluck('nombre','id');
        #$productos = Producto::all();       
        return view('admin.productos.index',['productos' => $productos,
                                             'filtros'=>$filtros,
                                             'categorias'=>$categoiras
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorias = Categoria::pluck('nombre','id');
        return View('admin.productos.create',['categorias'=>$categorias]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProducto $request)
    {
        
        $producto = new Producto($request->all());
        /* Procesando la imagen */
        $file = $request->file('ruta_imagen');
        if ($file != null){
            $name = 'carp_' . time() . '.' . $file->getClientOriginalExtension();
            $path = public_path() . '/imagenes/carp/';
            $file->move($path, $name);
            $producto->ruta_imagen = $name;    
        }
        $producto->save();
        $mje = 'Producto <'.$producto->nombre.'> fue guardado correctamente';
        return redirect()->route('productos.index')->with('success',$mje);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $producto = Producto::findOrFail($id);
        return view('admin.productos.show',['producto'=>$producto]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categorias = Categoria::pluck('nombre','id');
        $producto = Producto::findOrFail($id);
        return view('admin.productos.edit',['producto'=>$producto, 
                                            'categorias'=>$categorias]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProducto $request, $id)
    {
        
        $producto = Producto::findOrFail($id);
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->precio = $request->precio;
        $producto->stock = $request->stock;
        $producto->categoria_id = $request->categoria_id;
        /*Procesando la  imagen*/
        $file = $request->file('ruta_imagen');
        if ($file != null){
            $name = 'carp_' . time() . '.' . $file->getClientOriginalExtension();
            $path = public_path() . '/imagenes/carp/';
            $file->move($path, $name);
            $producto->ruta_imagen = $name;
        }
        
        $producto->save();
        $mje = 'Producto <'.$producto->nombre.'> fue editado correctamente';
        
        return redirect()->route('productos.index')->with('success',$mje);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();
        $mje = 'Producto <'.$producto->nombre.'> fue borrado correctamente';
        return redirect()->route('productos.index')->with('success',$mje);

    }

    public function detalle_producto($id){

        $prod = Producto::findOrFail($id);
        return view('partes.detalle-producto',['producto'=>$prod]);
    }
}
