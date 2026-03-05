<?php

use App\Http\Controllers\Admin\ArchivosMediaController;
use App\Http\Controllers\Admin\ArticuloController;
use App\Http\Controllers\Admin\InicioController;
use App\Http\Controllers\Admin\MetricasController;
use App\Http\Controllers\Admin\TipoArticuloController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\LoginClienteController;
use App\Http\Controllers\ZonaPrivadaController;
use App\Http\Controllers\Soap\Products;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use App\Models\Articulo;
use App\Models\Cliente;
use App\Http\Controllers\Admin\ClienteController;
use App\Http\Controllers\SitemapController;


Route::get('/sitemap.xml', [SitemapController::class, 'index'])
    ->name('sitemap');


Route::get('install-storage', function () {
    \Artisan::call('clear-compiled');
    \Artisan::call('cache:clear');
    \Artisan::call('config:clear');
    \Artisan::call('optimize:clear');
    \Artisan::call('route:clear');
    \Artisan::call('view:clear');
    $storage_path = storage_path('app/public');
    $public_path = realpath(base_path() . '/public') . '/storage';

    symlink($storage_path, $public_path);
    return "listo";
});


Route::get('/clear-cache', function () {
    // \Artisan::call('clear-compiled');
    \Artisan::call('cache:clear');
    \Artisan::call('config:clear');
    // \Artisan::call('optimize:clear');
    \Artisan::call('route:clear');
    \Artisan::call('view:clear');

    return "listo";
});

// Sitemap Index (principal)
Route::get('/sitemap.xml', [SitemapController::class, 'index']);

// Sitemaps individuales
Route::get('/sitemap-pages.xml', [SitemapController::class, 'pages']);
Route::get('/sitemap-categories.xml', [SitemapController::class, 'categories']);
Route::get('/sitemap-products-{page}.xml', [SitemapController::class, 'products'])
    ->where('page', '[0-9]+');


Route::group(['prefix' => '/'], function () {
    Route::get('/allClient', function () {
        dd(Articulo::updateApi());
        Cliente::updateApi();
    });
    Route::get('',  [PageController::class, 'index'])->name('page.inicio');
    Route::get('validar/{id}',  [PageController::class, 'validar'])->name('page.activar.cuenta');
    Route::get('/quienes_somos',  [PageController::class, 'empresa'])->name('page.empresa');
    Route::get('/catalogo',  [PageController::class, 'productosCategorias'])->name('page.productosCategorias');
    Route::get('/catalogo/{id}/{productosVisible}',  [PageController::class, 'productos'])->name('page.productos');
    Route::get('/search/{code}',  [PageController::class, 'search'])->name('page.search');
    Route::get('/articulo/{articulo}',  [PageController::class, 'producto'])->name('page.producto');

    Route::get('/producto/{id}',  [PageController::class, 'productoAPI'])->name('page.productoAPI');
    Route::get('/tutoriales',  [PageController::class, 'tutoriales'])->name('page.tutoriales');
    Route::get('/contacto',  [PageController::class, 'contactos'])->name('page.contacto');
    Route::post('/contacto', [PageController::class, 'contactosEnviar'])->name('page.contacto.post');
    Route::post('/search', [PageController::class, 'productosSearch'])->name('page.productosSearch');
    Route::get('/buscar-productos', [ArticuloController::class, 'buscarProductos']);

    Route::post('/guardars', [LoginClienteController::class, 'registro_cliente_post'])->name('page.nuevocliente');

    Route::post('loginCliente', [LoginClienteController::class, 'login'])->name('login.clientes');
    Route::post('registro_cliente_post', [LoginClienteController::class, 'registro_cliente_post'])->name('registro_cliente_post');
    Route::get('registro_cliente', [LoginClienteController::class, 'registro_cliente'])->name('registro_cliente');

    Route::post('/buscar', [PageController::class, 'buscar'])->name('buscar');

    Route::get('/registro', [LoginClienteController::class, 'registro_cliente'])->name('page.registro');
    Route::post('/registro', [LoginClienteController::class, 'registro_cliente_post'])->name('page.nuevoclienteform');
    ///RESET PASSWORD
    Route::get('/forgot-password', [PageController::class, 'password'])->name('password');
    Route::post('/forgot-password', [PageController::class, 'passwordpost'])->name('passwordpost');

    Route::post('loginCliente', [LoginClienteController::class, 'login'])->name('login.clientes');
    Route::post('registro_cliente_post', [LoginClienteController::class, 'registro_cliente_post'])->name('registro_cliente_post');
    Route::get('registro_cliente', [LoginClienteController::class, 'registro_cliente'])->name('registro_cliente');
});

Route::get('lang/{locale}', 'LocalizationController@lang')->name('locale');
Route::get('/adm/tipo-articulo/sincronizar', [TipoArticuloController::class, 'sincronizarCategorias']);

Route::post('/subcategorias', [TipoArticuloController::class, 'subcategorias'])->name('subcategorias');
Route::post('/tieneProductos', [TipoArticuloController::class, 'tieneProductos'])->name('tieneProductos');

Route::get('/cargaProductos', [TipoArticuloController::class, 'cargaProductos'])->name('cargaProductos');
Route::get('/cargaClientes', [TipoArticuloController::class, 'cargaClientes'])->name('cargaClientes');

Route::post('/changeIdioma', [InicioController::class, 'changeIdioma'])->name('changeIdioma');


Route::post('/guardar-cantidad', [ArticuloController::class, 'guardarCantidadEnSesion'])->name('guardar.cantidad');


Route::group(['prefix' => 'adm/archivosmedia', 'as' => 'archivosmedia.'], function() {
    Route::post('/',            [ArchivosMediaController::class, 'all']);
    Route::get('/{id}',         [ArchivosMediaController::class, 'find']);
    Route::post('/store/{id?}', [ArchivosMediaController::class, 'store']);
    Route::get('/delete/{id}',  [ArchivosMediaController::class, 'delete']);
});


Route::middleware(['auth.cliente'])->group(function () {
    Route::get('salir', [LoginClienteController::class, 'salir'])->name('salir');
    Route::post('update-client', [LoginClienteController::class, 'updateClient'])->name('page.update.cliente');
    Route::get('pedido', [ZonaPrivadaController::class, 'index'])->name('page.pedido');
    Route::get('pedido/{id}', [ZonaPrivadaController::class, 'productos'])->name('page.productosPedido');
    Route::post('pedido/{id}', [ZonaPrivadaController::class, 'productosSearch'])->name('page.productosPedidoSearch');
    Route::get('carrito', [ZonaPrivadaController::class, 'carrito'])->name('page.carrito');
    Route::get('mi-perfil', [ZonaPrivadaController::class, 'miperfil'])->name('page.mi.perfil');
    Route::get('lista-precios', [ZonaPrivadaController::class, 'listaPrecios'])->name('page.listadeprecios');
    Route::get('carrito-2', [ZonaPrivadaController::class, 'carritoPasoDos'])->name('page.carrito.paso.dos');
    Route::post('carrito-2', [ZonaPrivadaController::class, 'carritoPasoDosPost'])->name('page.carrito.paso.dos.post');
    Route::post('carrito', [ZonaPrivadaController::class, 'carrito_post'])->name('carrito_post');
    Route::post('carrito_enviar', [ZonaPrivadaController::class, 'carrito_enviar'])->name('carrito_enviar');
    Route::get('historial', [ZonaPrivadaController::class, 'historico'])->name('page.historial');
    Route::post('/enviarpedido', [ZonaPrivadaController::class, 'carrito_post'])->name('enviarpedido');
    Route::post('/enviar-correo', [ZonaPrivadaController::class, 'enviarMails'])->name('enviarMails');
    Route::post('/eventos', [MetricasController::class, 'store'])->name('eventos.store');
});

Route::get('/adm', function () {
    return view('welcome');
});


// endpoint JSON para Clientes paginados
Route::get('/adm/clientes', [ClienteController::class, 'all']);
Route::get('/adm/clientes/{page}', [ClienteController::class, 'all'])
    ->where('page', '[0-9]+');


Route::get('adm/{any}', function () {
    return view('welcome');
})->where('any', '.*');
