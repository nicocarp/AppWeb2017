<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Route;



class StoreCategoria extends FormRequest
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
                    'nombre' => 'required|unique:categorias|max:20'            
                ];            
            case 'PUT':
                return [
                    'nombre' => 'required|unique:categorias,nombre,'.dd($this->segment(3)).'|max:20'                    
                ];
            case 'DELETE':                
                return [];
            default: return [];
        }
        
    }
}
