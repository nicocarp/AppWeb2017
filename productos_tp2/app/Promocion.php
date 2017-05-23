<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Promocion extends Model
{
    protected $table = 'promociones';
    protected $fillable = ['mensaje', 'cantidad','porcentaje_descuento', 
    						'fecha_ini', 'fecha_fin'];
    protected $guarded = ['id'];


    public static function getIdsProdsEnPromosActivas($fecha_ini = NULL, $fecha_fin=NULL){
        
        if ($fecha_ini == NULL)
            $fecha_ini = date('Y-m-d');
        
        if ($fecha_fin == NULL){
            $string_sql = "SELECT producto_id 
                FROM producto_promocion 
                where producto_promocion.promocion_id in 
                    ( SELECT id 
                        FROM promociones as p 
                        WHERE (p.fecha_fin is NULL or p.fecha_ini < p.fecha_fin) AND 
                        (p.fecha_fin is NULL or p.fecha_fin > '".$fecha_ini."'))";
            
        }else{
            $string_sql = "SELECT producto_id 
                FROM producto_promocion 
                where producto_promocion.promocion_id in 
                    ( SELECT id 
                        FROM promociones as p 
                        WHERE (p.fecha_fin is NULL or p.fecha_fin > '".$fecha_ini."' ) AND 
                        (p.fecha_ini < '".$fecha_fin."'))";
            //dd($string_sql);
        }        
        $activas = DB::select($string_sql);
        return  collect($activas)->map(function($result){return $result->producto_id;});
    }
    

    public static function getPromosActivas($fecha_ini = NULL, $fecha_fin=NULL){
        if ($fecha_ini == NULL)
            $fecha_ini = date('Y-m-d');
        $promos = Promocion::where('fecha_ini','<=', $fecha_ini)
                         ->get();

        return $promos->filter(function($promo) use ($fecha_ini){ 
            return ($promo->fecha_fin == null or $promo->fecha_fin > $fecha_ini);
        });
        
    }

    public static function getProductosSinPromo(){
    	$activas = Promocion::getIdsProdsEnPromosActivas(date('Y-m-d'));
    	return Producto::whereNotIn('id', $activas)->get();    	
    }

    /* Recibe los items del carro y verifica que cumpla con la promo */
    public function getDescuentosEnCarro($arreglo_items){
        $query_ids_prods_en_promo = $this->productos()->pluck('producto_id');
        $hay_promo = $query_ids_prods_en_promo
                    ->every(function($id) use ($arreglo_items){
                        return in_array($id, array_keys($arreglo_items), true);
                    });
        if ($hay_promo){
            $cant_repe_promo = (int)$query_ids_prods_en_promo->map(function($id_prod) use ($arreglo_items){
                return $arreglo_items[$id_prod];
            })->min();
            $cant_repe_promo = (int)( $cant_repe_promo / $this->cantidad);
            $total_descuento = $this->getDescuentos() * $cant_repe_promo;
            return $total_descuento;
        }
        return 0;

    }
    public function productos()
	{
	    return $this->belongsToMany('App\Producto');
	}
	public function estaActiva($fecha){
		return (($this->fecha_fin == null || $this->fecha_fin > $fecha) &&
                    $this->fecha_ini <= $fecha );
	}
    public function estaraActiva($fecha){
        return (($this->fecha_fin == null || $this->fecha_fin > $fecha) &&
                    $this->fecha_ini > $fecha );
    }
    
    public function getEstado($fecha = NULL){
        if ($fecha == NULL)
            $fecha = date('Y-m-d');
        if ($this->estaraActiva($fecha)){
            return 2; //'estaraActiva'
        }else{
            if ($this->estaActiva($fecha)){
                return 1; // 'activa'
            }else{
                return 0 ; // 'No Activa'
            }
        }
    }



	/**
     * Devuelve precio total de los prouctos de la promocion
     */
	public function getTotal(){
        $cantidad = $this->cantidad;
		return  $this->productos
						->map(function($prod){return $prod->precio;})
						->reduce(function($acum, $elem)use($cantidad){
                            return $acum + ($elem * $cantidad);
                        });
	} 	
	public function getDescuentos(){		
        return ($this->porcentaje_descuento * $this->getTotal()) / 100;
	}	
}
