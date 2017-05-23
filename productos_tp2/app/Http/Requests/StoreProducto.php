<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProducto extends FormRequest
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
                    'nombre' => 'required|unique:productos|max:30',
                    'precio' => 'required|numeric|min:0',
                    'stock' => 'required|integer|min:0',
                    'descripcion' => 'required|max:100',
                    'ruta_imagen' => 'required',
                    'categoria_id' => 'exists:categorias,id'
                ];
            case 'PUT':
                
                return [
                    'nombre' => 'required|unique:productos,nombre,'.$this->id.'|max:30',
                    'precio' => 'required|numeric|min:0',
                    'stock' => 'required|integer|min:0',
                    'descripcion' => 'required|max:100',                    
                    'categoria_id' => 'exists:categorias,id'
                ];
            case 'DELETE':                
                return [];
            default: return [];
        }
    }
}
