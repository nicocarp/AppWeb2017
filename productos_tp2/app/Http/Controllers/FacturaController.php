<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Http\Request;
use PDF;
use App\Factura;


class FacturaController extends Controller
{
    public function index(Request $request){
		$facturas = Factura::where('usuario_id', Auth::user()->id)->orderBy('fecha','desc')->get();
		return View('compras.factura-index')->with('facturas',$facturas);
	}
	public function show(Request $request, $id){
		$factura = Factura::findOrFail($id);
		$usuario_id = Auth::user()->id == $factura->usuario_id;
		if (Auth::user()->rol == 'admin'){
			return View('compras.factura-show')->with('factura',$factura);
		}else{
			if ($usuario_id == $factura->usuario_id	)
				return View('compras.factura-show')->with('factura',$factura);
		}
		return Redirect::route('home')->with('error', 'Error no tiene acceso a esa factura');
	}

	/* ESta funcion en principio no va  PREGUNTAR*/
	public function descargarPDF(Request $request, $id){
		$factura = Factura::findOrFail($id);		
		view()->share('factura',$factura);
        $pdf = PDF::loadView('compras.factura');
        return $pdf->download('factura.pdfview');
	}
	public function showPDF(Request $request, $id){
		$factura = Factura::findOrFail($id);
		$pdf = PDF::loadView('compras.factura-pdf', ['factura'=>$factura]);
		$nombre_pdf = "Factura-".$factura->fecha.".pdf";
		return $pdf->stream($nombre_pdf);
	}
}
