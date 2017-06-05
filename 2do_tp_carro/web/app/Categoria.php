<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';
    protected $fillable = ['nombre'];
    protected $guarded = ['id'];

    /**
     * The productos that belong to the categoria.
     */
    public function productos()
    {
        return $this->hasMany('App\Producto');
    }

}
