<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use App\Carro;
use App\ValidadorStock;

class StoreCarro extends FormRequest
{
    public function __construct(Request $request){
        $productos_en_carro = $request->session()->get('productos_en_carro');
        $validador_stock = new ValidadorStock();
        $this->carro = new Carro($productos_en_carro, $validador_stock);
        $this->validador_stock = $validador_stock;
    }
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
        // POST = agregarAlCarro  PUT = actualziarCantidadEnCarro
        switch($this->method()){
            case 'POST':
                return [
                    'producto_id' => 'required|integer|exists:productos,id',
                    'promocion_id' => 'integer|exists:promociones,id',
                    'cantidad' => 'required|integer|min:1|max:100'                    
                ];
            case 'PUT':   
                return [
                    'productos_id' => 'required|array|min:1',
                    'cantidades' => 'required|array|min:1',
                    'cantidades.*' => 'required|integer|min:1|max:100',
                    'productos_id.*' => 'required|integer|exists:productos,id'
                ];
            case 'DELETE':                
                return [
                    'producto_id' => 'required|integer|exists:productos,id',
                ];
            default: return [];
        }
    }
    public function messages()  
    {   
        return [
            'producto_id' => 'ID de producto no es correcto',
            'cantidad.required' => 'Ingrese una Cantidad valida',
            'cantidad.min' => 'Debe ingresar al menos una unidad',
            'cantidad.max' => 'La Cantidad maxima para agregar al carro es 100',
            
            
        ];
    }
}
