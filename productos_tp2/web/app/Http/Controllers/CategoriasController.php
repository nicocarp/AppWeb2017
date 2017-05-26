<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;
use App\Http\Requests\StoreCategoria;
class CategoriasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias = Categoria::all();
        $productos=$categorias[0]->productos();

        return View('admin.categorias.index', [
                                                'categorias'=>$categorias,
                                                'productos'=>$productos
                                                ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('admin.categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoria $request)
    {
        
        $categoria = new Categoria($request->all());
        $categoria->save();
        $mje = 'Categoria <'.$categoria->nombre.'> fue guardado correctamente';
        return redirect()->route('categorias.create')->with('success',$mje);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(StoreCategoria $request, $id)
    {
        $categoria = Categoria::findOrFail($id);
        $productos = $categoria->productos;
        return View('admin.categorias.show',['categoria'=>$categoria,'productos'=>$productos]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categoria = Categoria::findOrFail($id);
        return View('admin.categorias.edit', ['categoria'=>$categoria]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCategoria $request, $id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->nombre = $request->nombre;
        $categoria->save();
        $mje = 'Categoria <'.$categoria->nombre.'> fue actualizada correctamente';
        
        return redirect()->route('categorias.index')->with('success',$mje);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(StoreCategoria $request, $id)
    {
        $categoria = Categoria::findOrFail($id);
        $productos = $categoria->productos;
        $tipo=$mje="";
        
        if (count($productos) == 0) {
            $categoria->delete();
            $mje = 'Categoria <'.$categoria->nombre.'> fue borrada correctamente';
            $tipo="success";
        }else{
            $mje = 'Categoria <'.$categoria->nombre.'> no puede ser borrada
            ya que tiene productos asociadas';  
            $tipo="error";
        }       
        return redirect()->route('categorias.index')->with($tipo,$mje);
    }
}
