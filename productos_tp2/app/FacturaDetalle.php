<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacturaDetalle extends Model
{
	protected $table = 'factura_detalles';
    protected $fillable = ['cantidad', 'factura_id','producto_id', 
    						'precio'];
    protected $guarded = ['id'];
    
    public function factura(){    	
    	return $this->belongsTo('App\Factura');
    }
    public function producto(){    	
    	return $this->belongsTo('App\Producto');
    }
}
