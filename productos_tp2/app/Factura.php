<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
	protected $table = 'facturas';
    protected $fillable = ['descuentos', 'fecha', 'usuario_id'];
    protected $guarded = ['id'];

    public function usuario(){    	
    	return $this->belongsTo('App\User');
    }
    public function facturaDetalles()
    {
        return $this->hasMany('App\FacturaDetalle');
    }
    public function getPrecioSinDescuento()
    {   

        return $this->facturaDetalles
                    ->reduce(function($acum, $detalle){
                        return $acum + ($detalle->precio * $detalle->cantidad);
                    });        
    }
    public function getCantProductos()
    {
        $total_productos = $this->facturaDetalles()->pluck('cantidad');
        return $total_productos->reduce(function($acum, $cant){return $acum + $cant;});
    }
}
