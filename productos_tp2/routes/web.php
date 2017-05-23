<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/* RUTAS DE EJEMPLO */
Route::get('parametros/{id}', function ($id) {
    if ($id)
		return 'Parametro recibido22 '.$id;
	return 'PRINCIPAL';    
});
Route::get('prueba', function () {
    return 'probando no mas';
});
/* FIN EJEMPLOS BORRARLAS DESPUES */

/* USUARIOS */
Route::get('usuarios', function () {
    return 'Usuarios';
});


Route::get('producto', function(){
	return 'No podes entrar';
})->middleware('can:crear_producto');
/* Fin usuarios */
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/catalogo', 'Catalogo@index')->name('catalogo');
Route::get('/promociones','Catalogo@promociones')->name('compras.promociones.index');

Route::get('detalle_producto/{id}', [
		'uses' => 'ProductosController@detalle_producto',
		'as' => 'compras.detalle.producto'	
	]);

Route::group(['prefix' => 'compras', 'middleware'=>'auth'], function(){
	Route::post('addCar/', [
		'uses' => 'CarroController@agregarAlCarro',
		'as' => 'compras.add.carro'
	]);
	Route::get('addCar/', 'Catalogo@index');
	Route::delete('deleteItemCar/', [
		'uses' => 'CarroController@sacarDelCarro',
		'as' => 'compras.sacar.carro'	
	]);
	Route::get('addCarCombo/{id}', [
		'uses' => 'CarroController@agregarComboAlCarro',
		'as' => 'compras.add.carro.combo'	
	]);
	Route::get('showCarro/', [
		'uses' => 'CarroController@index',
		'as' => 'compras.ver.carro'	
	]);
	
	Route::put('updateCantCarro/', [
		'uses' => 'CarroController@actualizarCantidad',
		'as' => 'compras.actualizar.cantidad.carro'	
	]);	
	Route::get('checkoutCarro', [
		'uses' => 'CarroController@efectuar_compra',
		'as' => 'compras.efecutar.compra'
	]);
	Route::get('facturas', [
		'uses' => 'FacturaController@index',
		'as' => 'compras.facturas.index'
	]);
	Route::get('facturas/{id}', [
		'uses' => 'FacturaController@show',
		'as' => 'compras.facturas.show'
	]);
	Route::get('facturas/pdf/{id}', [
		'uses' => 'FacturaController@showPDF',
		'as' => 'compras.facturas.show.pdf'
	]);
	Route::get('descargarFactura/{id}', [
		'uses' => 'FacturaController@descargarPDF',
		'as' => 'compras.facturas.descargar.pdf'
	]);
});


Route::group(['prefix' => 'admin', 'middleware'=>'can:acceso_admin'], function(){
	Route::resource('productos', 'ProductosController');
	Route::get('productos/{id}/destroy', [
		'uses' => 'ProductosController@destroy',
		'as'  => 'admin.productos.destroy' 
	]);

	Route::resource('categorias', 'CategoriasController');
	Route::get('categorias/{id}/destroy', [
		'uses' => 'CategoriasController@destroy',
		'as'  => 'admin.categorias.destroy' 
	]);

	Route::resource('promociones','PromocionesController');
	Route::get('promociones/{id}/destroy', [
		'uses' => 'PromocionesController@destroy',
		'as'  => 'admin.promociones.destroy' 
	]);
	Route::get('usuarios/', [
		'uses' => 'UsuariosController@index',
		'as'  => 'admin.usuarios.index' 
	]);
});

