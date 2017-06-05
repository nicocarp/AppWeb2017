<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePromocion extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
            switch($this->method()){
            case 'POST':
                return [
                    'mensaje' => 'required|max:100',
                    'cantidad' => 'required|integer|min:0',
                    'porcentaje_descuento' => 'required|integer|min:0|max:100',
                    'fecha_ini' => 'required|date|fecha_mayor_igual_actual',                    
                    'fecha_fin' => 'mayor_fecha_ini',
                    'id_productos' => 'required|array|min:1|arreglo_sin_repeticion|productos_unicos_en_promo',
                    'id_productos.*' => 'integer|exists:productos,id'
                ];            
            default: return [];
            }

    }
    public function messages()  
    {   
        return [
            'mensaje.required' => 'Ingrese un Mensaje',
            'cantidad.required' => 'ingrese una Cantidad',
            'id_productos.arreglo_sin_repeticion' => 'No se puede repetir el producto en la Promo',
            'id_productos.*.exists' => 'Producto seleccionado Incorrecto',
            'fecha_ini.fecha_mayor_igual_actual' => 'Fecha inicio debe ser mayor a la fecha Actual',
            'fecha_fin.mayor_fecha_ini' => 'Fecha de fin no puede ser menor a la fecha de inicio',
            
        ];
    }
}
