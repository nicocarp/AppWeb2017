<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;
use App\Promocion;

use App\Producto;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);


        /*Validamos que ids no sean de productos que ya tengan asociado una promo ACTIVA */
        Validator::extend('mayor_fecha_ini', function ($attribute, $value, $parameters, $validator)
        {   
            $fecha_inicio = $validator->getData()['fecha_ini'];
            if ($value == '')
                return true;
            return $value > $fecha_inicio;
        });
        Validator::extend('productos_unicos_en_promo', function ($attribute, $value, $parameters, $validator)
        {
            $fecha_ini = $validator->getData()['fecha_ini'];
            $fecha_fin = $validator->getData()['fecha_fin'];

            $ids_prods_promo = Promocion::getIdsProdsEnPromosActivas($fecha_ini,$fecha_fin);
            
            /*$promos_activas = Promocion::getPromosActivas($fecha_ini);
            $cant_ids_de_prods_en_promo =  $promos_activas->map(function($promo_activa){
                    return $promo_activa->productos->map(function($producto){
                        return $producto->id;
                    });
                })
                ->collapse()
                ->intersect($value)
                ->count();*/
                /* si cant_ids.. es = 0 -> los ids en alta no estan presentes en promos activas */
            //dd(collect($ids_prods_promo)->intersect($value)->count());
             $cant_ids_de_prods_en_promo = collect($ids_prods_promo)->intersect($value)->count();
            
            return ($cant_ids_de_prods_en_promo == 0);            
        });
        /*Validamos Arreglo sin repeticion */
        Validator::extend('arreglo_sin_repeticion', function ($attribute, $value, $parameters, $validator)
        {
            $result = collect($value)->unique();
            return $result->count() == collect($value)->count();
        });

        /* Validamos que la fecha de un unput sea igual o mayor al dia actual */
        Validator::extend('fecha_mayor_igual_actual', function ($attribute, $value, $parameters, $validator)
        {
            return $value >= Date('Y-m-d');
        });
        Validator::extend('fecha_menor', function ($attribute, $value, $parameters, $validator)
        {   
            dd($parameters[0]);
            return $value < $parameters[0];
        });
        

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
