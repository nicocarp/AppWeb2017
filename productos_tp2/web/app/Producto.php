<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Exception;

//class ExcepciónFaltaStock extends Exception { }
class Producto extends Model
{
    protected $table = 'productos';
    protected $fillable = ['nombre', 'precio','descripcion', 
    						'stock', 'ruta_imagen', 'categoria_id'];
    protected $guarded = ['id'];

    public function categoria(){    	
    	return $this->belongsTo('App\Categoria');
    }
    public function scopeNombre($query, $nombre){
    	if ($nombre)
    		return $query->where("nombre","LIKE", "%$nombre%");	
    	
    }
    public function scopeCategoria($query, $categoria_id){
    	if ($categoria_id)
    		return $query->where("categoria_id","$categoria_id");	
    	
    }
    public function scopeStock($query, $nombre){
    	if ($nombre)
    		return $query->where("nombre","LIKE", "%$nombre%");	
    	
    }
    public function promociones(){
        return $this->belongsToMany('App\Promocion');

    }
    public function decrementarStock($cantidad){
        $result = $this->stock -= $cantidad;
        if ($result < 0){
            $mje = "No hay Suficiente Stock para producto ".$this->nombre." .";
            throw new \Exception($mje);
        }
        $this->stock = $result;
        $this->save();
            
    }
}
