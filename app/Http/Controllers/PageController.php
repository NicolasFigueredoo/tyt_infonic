<?php

namespace App\Http\Controllers;

use App\Models\Contacto;
use App\Models\Empresa;
use App\Models\Inicio;
use App\Models\Slider;
use App\Models\Tutorial;
use App\Models\Cliente;
use App\Models\Vendedor;
use App\Models\TipoArticulo;
use App\Models\ArticuloSuela;
use App\Models\Metadato;
use App\Models\CategoriasArticulo;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactoMail;
use App\Mail\CuentaActiva;
use App\Models\Articulo;
use Illuminate\Support\Facades\Auth;
use stdClass;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class PageController extends Controller
{
    public function index()
    {

        $active = 'page.inicio';
        $sliders   = Slider::where('seccion', 'bannerPrincipal')->orderBy('orden', 'ASC')->get();
        $categorias = TipoArticulo::orderBy('orden', 'ASC')->where('oculto', 'false')->where('destacado', 'true')->take(6)->get();
        $categoriasprin = TipoArticulo::orderBy('orden', 'ASC')->where('oculto', 'false')->where('principal', 'true')->get();
        $articulos = Articulo::orderBy('orden', 'ASC')->where('oculto', 'false')->where('destacado', 'true')->whereNotNull('sub_categoria')->whereNotNull('orden')->take(8)->get();
        $inicio = Inicio::first();
        $metadatos = Metadato::where('seccion', 'inicio')->first();
        $modal = Contacto::where('seccion', '=', 'modal')->where('orden', 'true')->first();
        $logos = Slider::where('seccion', 'logos')->orderBy('orden', 'ASC')->get();
        $headerexpand = true;
        $headerinicio = true;
        // return view('page.inicio', compact('sliders', 'metadatos', 'active', 'inicio', 'categorias','articulos','modal','logos'));
        return view('page.newinicio', compact('sliders', 'metadatos', 'active', 'inicio', 'categorias', 'articulos', 'modal', 'logos', 'categoriasprin', 'headerexpand', 'headerinicio'));
    }
    public function validar($id)
    {
        $cliente = Cliente::find($id);
        $cliente->estado = 1;

        $nuevaContrasena = Str::random(10);

        $cliente->password = Hash::make($nuevaContrasena);

        $cliente->save();


        $email = new CuentaActiva($cliente, $nuevaContrasena);
        Mail::to('info@tytsa.com.ar')->send($email);
        Mail::to('dcamacho.tytsa@gmail.com')->send($email);
        Mail::to('lmorales.tytsa@gmail.com')->send($email);
        Mail::to('ariel@tytsa.com.ar')->send($email);
        Mail::to($cliente->email)->send($email);


        $active = "";
        $inicio = Inicio::first();
        return view('page.activa', compact('active', 'inicio'));
    }

    public function empresa()
    {
        $active = 'page.empresa';
        $empresa = Empresa::find(1);
        $sliders   = Slider::where('seccion', 'empresa')->orderBy('orden', 'ASC')->get();
        $inicio = Inicio::first();
        $metadatos = Metadato::where('seccion', 'empresa')->first();
        $title = "Quienes Somos";
        $headerexpand = true;
        // return view('page.empresa', compact('active', 'empresa', 'inicio', 'metadatos', 'sliders'));
        return view('page.newempresa', compact('active', 'empresa', 'inicio', 'metadatos', 'sliders', 'title', 'headerexpand'));
    }

    public function tutoriales()
    {
        $active = 'page.tutoriales';
        $titulo = 'Novedades';
        $route = 'page.tutoriales';
        $tutoriales = Tutorial::orderBy('orden', 'ASC')->paginate(6);

        return view('page.tutoriales', compact('active', 'tutoriales', 'titulo', 'route'));
    }

    public function productosCategorias($page = 1)
    {
        $active = 'page.productos';
        if (Auth::guard('cliente')->check()) {
            $active = 'page.productosCategorias';
        }

        $titulo = 'Categorias';
        $route = 'page.productos';

        // Categorías predeterminadas:
        $defaultCategorias = TipoArticulo::where('oculto', '=', 'false')
            ->where('principal', 'true')
            ->orderByRaw("CASE WHEN orden IS NULL OR orden = '' THEN 1 ELSE 0 END, orden ASC")
            ->limit(3)
            ->get();

        // Si el cliente está logueado, consultamos sus categorías asignadas
        if (Auth::guard('cliente')->check()) {
            $cliente = Auth::guard('cliente')->user();
            $asignadas = $cliente->categoriasPermitidas()->where('principal', 'true')->get();

            // Si el cliente tiene alguna asignada, se usan esas; si no, se muestran las predeterminadas.
            $categorias = $asignadas->isNotEmpty() ? $asignadas : $defaultCategorias;
        } else {
            // Si no está logueado, se muestran las categorías predeterminadas.
            $categorias = $defaultCategorias;
        }

        $title = "Productos";
        $metadatos = Metadato::where('seccion', 'catalogo')->first();
        $headerexpand = true;
        $inicio = Inicio::first();

        return view('page.newproductosCategorias', compact('inicio', 'active', 'categorias', 'titulo', 'route', 'metadatos', 'title', 'headerexpand'));
    }

    public function productos($id, $productosVisible)
    {
        $active = 'page.productos';
        $titulo = 'Categorias';
        $route = 'page.producto';
        $inicio = Inicio::first();


        // Ajustar la consulta para que los art��culos con 'orden' nulo o vac��o aparezcan al final
        $articulos = Articulo::where('oculto', 'false')->whereNotNull('sub_categoria')
            ->orderByRaw("CASE WHEN orden IS NULL OR orden = '' THEN 1 ELSE 0 END, orden ASC")
            ->get();

        $categoriasSub = '';
        $tieneProductos = 0;
        $productos = collect();
        $categoria = TipoArticulo::find($id);
        $categoriaSelect = TipoArticulo::find($categoria->id);

        if ($categoria->principal == 'false') {
            if ($productosVisible == 0) {
                $categorias = TipoArticulo::orderByRaw("CASE WHEN orden IS NULL OR orden = '' THEN 1 ELSE 0 END, orden ASC")
                    ->where('oculto', 'false')
                    ->where('principal', 'false')
                    ->where('code', $categoria->code)
                    ->get();

                $categoriaParent = TipoArticulo::orderByRaw("CASE WHEN orden IS NULL OR orden = '' THEN 1 ELSE 0 END, orden ASC")
                    ->where('oculto', 'false')
                    ->where('id', $categorias[0]->sub_categoria_id)
                    ->get();

                $categoriaPrincipal = TipoArticulo::orderByRaw("CASE WHEN orden IS NULL OR orden = '' THEN 1 ELSE 0 END, orden ASC")
                    ->where('oculto', 'false')
                    ->where('id', $categoriaParent[0]->sub_categoria_id)
                    ->first();

                $categoriaPrincipalVer = $categoriaPrincipal;
                $categorias = TipoArticulo::orderByRaw("CASE WHEN orden IS NULL OR orden = '' THEN 1 ELSE 0 END, orden ASC")
                    ->where('oculto', 'false')
                    ->where('principal', 'false')
                    ->where('sub_categoria_id', $categoriaPrincipal->id)
                    ->get();

                $categoriasSub = $categorias;
            } else {
                $categoriaPrincipal = TipoArticulo::orderByRaw("CASE WHEN orden IS NULL OR orden = '' THEN 1 ELSE 0 END, orden ASC")
                    ->where('id', $categoria->sub_categoria_id)
                    ->first();

                if ($categoriaPrincipal->principal == 'false') {
                    $categorias = TipoArticulo::orderByRaw("CASE WHEN orden IS NULL OR orden = '' THEN 1 ELSE 0 END, orden ASC")
                        ->where('oculto', 'false')
                        ->where('sub_categoria_id', $categoriaPrincipal->sub_categoria_id)
                        ->get();
                } else {
                    $categorias = TipoArticulo::orderByRaw("CASE WHEN orden IS NULL OR orden = '' THEN 1 ELSE 0 END, orden ASC")
                        ->where('oculto', 'false')
                        ->where('sub_categoria_id', $categoriaPrincipal->id)
                        ->get();
                }

                if ($categoriaPrincipal->principal == 'true') {
                    $categoriaPrincipalVer = $categoriaPrincipal;
                } else {
                    $categoriaPrincipal = TipoArticulo::orderByRaw("CASE WHEN orden IS NULL OR orden = '' THEN 1 ELSE 0 END, orden ASC")
                        ->where('id', $categoriaPrincipal->sub_categoria_id)
                        ->first();

                    if ($categoriaPrincipal->principal == 'true') {
                        $categoriaPrincipalVer = $categoriaPrincipal;
                    } else {
                        $categoriaPrincipal = TipoArticulo::orderByRaw("CASE WHEN orden IS NULL OR orden = '' THEN 1 ELSE 0 END, orden ASC")
                            ->where('id', $categoriaPrincipal->sub_categoria_id)
                            ->first();

                        $categoriaPrincipalVer = $categoriaPrincipal;
                    }
                }

                $categoriasSub = TipoArticulo::where('sub_categoria_id', $id)->where('oculto', 'false')->get();
            }
        } else {
            $categoriaPrincipalVer = $categoria;

            $categorias = TipoArticulo::orderByRaw("CASE WHEN orden IS NULL OR orden = '' THEN 1 ELSE 0 END, orden ASC")
                ->where('oculto', 'false')
                ->where('principal', 'false')
                ->where('sub_categoria_id', $categoria->id)
                ->get();

            $categoriasSub = $categorias;
        }

        $isParent = TipoArticulo::where('sub_categoria_id', $id)->get();

        if ($isParent->isEmpty()) {
            $tieneProductos = 1;
            $productos = $categoria->productos;
        }

        $productosCat = $categoria->productos;

        $categoriasHijos = TipoArticulo::where('sub_categoria_id', $categoria->id)->get();

        if ($productosCat) {
            $tieneProductos = 1;
            $productos = $productosCat;
        }

        if (!$categoriasHijos->isEmpty()) {
            foreach ($categoriasHijos as $categoriaHija) {

                $productosHija = $categoriaHija->productos;

                if (!$productosHija->isEmpty()) {
                    $productos = $productos->merge($productosHija);
                }
            }

            if ($categoria->principal == 'true') {
                $tieneProductos = 0;
            }
        }

        $metadatos = Metadato::where('seccion', 'catalogo')->first();


        $categoriasF = TipoArticulo::orderByRaw("CASE WHEN orden IS NULL OR orden = '' THEN 1 ELSE 0 END, orden ASC")
            ->where('oculto', 'false')
            ->where('principal', 'true')
            ->get();


        if (Auth::guard('cliente')->check()) {
            $cliente = Auth::guard('cliente')->user();
            $asignadas = $cliente->categoriasPermitidas()->where('principal', 'true')->get();

            // Si el cliente tiene alguna asignada, se usan esas; si no, se muestran las predeterminadas.
            $categoriasprin = $asignadas->isNotEmpty() ? $asignadas : $categoriasF;
        } else {
            // Si no está logueado, se muestran las categorías predeterminadas.
            $categoriasprin = $categoriasF;
        }



        if (request()->ajax()) {

            return view('partials.productosOrCategorias', compact('categoria', 'productos', 'categoriasSub', 'tieneProductos'))->render();
        }

        return view('page.newcategoria', compact('inicio', 'active', 'categoria', 'categorias', 'titulo', 'route', 'metadatos', 'productos', 'categoriasprin', 'categoriasSub', 'tieneProductos', 'categoriaPrincipalVer', 'categoriaSelect'));
    }

    public function producto(Articulo $articulo)
    {
        $inicio = Inicio::first();
        $active = 'page.productos';
        $producto   = $articulo;
        $categoria = TipoArticulo::where('id', $producto->sub_categoria)->first();


        $categorias = [];
        $categoriaSelect = $categoria;
        $inicio = Inicio::first();


        if (!$categoria) {
            $categorias = TipoArticulo::orderBy('orden', 'ASC')->where('oculto', 'false')->where('principal', 'false')->get();
        } else {


            if ($categoria->principal == 'false') {
                $categorias = TipoArticulo::orderBy('orden', 'ASC')
                    ->where('oculto', 'false')
                    ->where('principal', 'false')
                    ->where('id', $categoria->sub_categoria_id)
                    ->get();



                if ($categorias->isNotEmpty()) { // Verifica si hay elementos en la colección
                    $categoriasPadre = TipoArticulo::orderBy('orden', 'ASC')
                        ->where('oculto', 'false')
                        ->where('principal', 'false')
                        ->where('sub_categoria_id', $categorias[0]->sub_categoria_id)
                        ->get();

                    $categorias = $categoriasPadre;
                } else {


                    $categorias = TipoArticulo::orderBy('orden', 'ASC')
                        ->where('oculto', 'false')
                        ->where('sub_categoria_id', $categoria->sub_categoria_id)
                        ->get();
                }
            } else {
                $categorias = TipoArticulo::orderBy('orden', 'ASC')->where('oculto', 'false')->where('principal', 'false')->where('sub_categoria_id', $categoria->id)->get();
            }
        }


        $metadatos = Metadato::where('seccion', 'catalogo')->first();
        $promo = false;
        $articulos = Articulo::orderBy('orden', 'ASC')->where('oculto', 'false')->where('destacado', 'true')->whereNotNull('sub_categoria')->whereNotNull('orden')->take(8)->get();

        return view('page.newproducto', compact('inicio', 'active', 'producto', 'metadatos', 'categorias', 'promo', 'articulos', 'categoria', 'inicio'));
    }


  public function productosSearch(Request $request)
{
    $active = 'page.productos';
    $titulo = 'Categorias';
    $route = 'page.producto';
    $inicio = Inicio::first();
    
    // Realizar la búsqueda de productos con validación mejorada
    $productos = Articulo::where(function($query) use ($request) {
            $query->where('name', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('code', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('codigoAnterior', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('description', 'LIKE', '%' . $request->search . '%');
        })
        ->where('oculto', 'false')
        ->whereNotNull('slug') // Asegurar que tenga slug
        ->get();
    
    $categoria = '';
    $categorias = TipoArticulo::orderByRaw("CASE WHEN orden IS NULL OR orden = '' THEN 1 ELSE 0 END, orden ASC")
        ->where('oculto', 'false')
        ->get();
    $metadatos = Metadato::where('seccion', 'catalogo')->first();
    $categoriasprin = TipoArticulo::orderByRaw("CASE WHEN orden IS NULL OR orden = '' THEN 1 ELSE 0 END, orden ASC")
        ->where('oculto', 'false')
        ->where('principal', 'true')
        ->get();
    $search = $request->search;
    
    return view('page.NewSearchProductos', compact('inicio', 'active', 'categorias', 'titulo', 'route', 'metadatos', 'productos', 'categoriasprin', 'search', 'categoria'));
}

    public function productoAPI($code)
    {
        //$response = asset('archivos/productos.xml');
        $url = asset('archivos/productos.xml');
        $ruta = public_path(ltrim(parse_url($url, PHP_URL_PATH), '/'));
        $xml = simplexml_load_file($ruta);

        $productos = $xml->children()->Products->Product;

        $coleccion_productos = collect();

        //dd($productos);
        foreach ($productos as $producto) {
            $prod = new stdClass;
            $producto = $producto->attributes();
            $prod->cat = (string) $producto->FamilyId;
            $prod->code = (string) $producto->AppCode;
            $prod->name = (string) $producto->FullName;
            $prod->precio = (float) $producto->Price;
            $prod->imagen = null;
            $prod->cantidad = 100;
            $prod->logo = '<svg width="83" height="78" viewBox="0 0 83 78" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M73.4886 14.6025C75.9151 20.0439 76.1838 26.7519 76.1838 32.6621C76.1838 48.0709 66.5559 62.4294 49.6167 62.4294H47.3065C31.6076 62.4294 23.8503 50.7795 24.3766 36.5876H47.3065V34.6592C47.3065 26.1418 41.3241 20.0024 32.6753 20.0024C23.2865 20.0024 16.889 29.7571 16.889 39.6732C16.889 55.9211 26.3769 77.3644 45.4316 77.4586C64.9948 77.5561 82.7293 61.3523 82.7293 41.2162V39.2875C82.7293 31.7454 77.2999 17.3999 73.4886 14.6025Z" fill="#007D44"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.24075 62.8565C6.81429 57.4152 6.54554 50.7071 6.54554 44.7969C6.54554 29.3881 16.1735 15.0296 33.1127 15.0296H35.4229C51.1217 15.0296 58.879 26.6795 58.3528 40.8715H35.4229V42.7999C35.4229 51.3171 41.4053 57.4567 50.054 57.4567C59.4429 57.4567 65.8403 47.702 65.8403 37.7858C65.8403 21.538 56.3525 0.0947014 37.2978 0.000437688C17.7346 -0.0970608 0 16.1067 0 36.2428V38.1716C0 45.7137 5.42945 60.0591 9.24075 62.8565Z" fill="#007D44"/>
            </svg>';
            $coleccion_productos->push($prod);
        }
        $active = 'page.productos';
        //$producto = Articulo::find($code);
        $producto = $coleccion_productos->where('code', $code)->first();
        $categorias = TipoArticulo::orderBy('orden', 'ASC')->get();
        $metadatos = Metadato::where('seccion', 'catalogo')->first();

        return view('page.newproducto', compact('active', 'producto', 'metadatos', 'categorias'));
        //return view('page.producto', compact('active', 'producto', 'metadatos', 'categorias'));
    }
    public function search($code)
    {
        $inicio = Inicio::first();

        $active = 'page.productos';
        $titulo = 'Categorias';
        $route = 'page.producto';
        $articulos = Articulo::where('oculto', 'false')->whereNotNull('sub_categoria')->get();

        $categoria = "";
        $productos = Articulo::where('code', 'LIKE', '%' . $code . "%")->whereNotNull('sub_categoria')->where('oculto', 'false')->paginate(25);
        $categorias = TipoArticulo::orderBy('orden', 'ASC')->where('oculto', 'false')->get();

        $metadatos = Metadato::where('seccion', 'catalogo')->first();

        return view('page.newcategoria', compact('inicio', 'active', 'categoria', 'categorias', 'titulo', 'route', 'metadatos', 'productos'));
        // return view('page.categoria', compact('active', 'categoria', 'categorias', 'titulo', 'route', 'metadatos', 'productos'));
    }

    public function contactos()
    {
        $active = 'page.contacto';
        //$etiquetas = Etiqueta::orderBy('orden', 'ASC')->get();
        $metadatos = Metadato::where('seccion', 'contacto')->first();
        $inicio = Inicio::first();

        return view('page.newcontacto', compact('active', 'metadatos', 'inicio'));
    }

    public function contactosEnviar(Request $request)
    {
        // Verificar reCAPTCHA
        $recaptchaResponse = $request->input('g-recaptcha-response');
        $secretKey = env('RECAPTCHA_SECRET_KEY'); // Configura esta clave en tu archivo .env

        $recaptchaVerifyResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secretKey,
            'response' => $recaptchaResponse,
            'remoteip' => $request->ip(), // Opcional: puedes incluir la IP del usuario
        ]);



        $recaptchaData = $recaptchaVerifyResponse->json();

        // Validar el score del captcha
        if (!$recaptchaData['success'] || $recaptchaData['score'] < 0.5) { // Ajusta el threshold si es necesario
            return response()->json(['error' => 'La validación del captcha falló. Inténtalo nuevamente.'], 422);
        }

        // Procesar el formulario si el captcha es válido
        $dataRequest = $request->all();
        $file = isset($dataRequest["file"]) ? $request->file('file') : null;

        Mail::to('lmorales.tytsa@gmail.com')->send(new ContactoMail($dataRequest, $file));
        Mail::to('info@tytsa.com.ar')->send(new ContactoMail($dataRequest, $file));
        Mail::to('dcamacho.tytsa@gmail.com')->send(new ContactoMail($dataRequest, $file));
        Mail::to('ariel@tytsa.com.ar')->send(new ContactoMail($dataRequest, $file));

        if (count(Mail::failures()) > 0) {
            $respuesta = '*Algo salió mal, reintentar más tarde.';
        } else {
            $respuesta = '*Gracias por comunicarte, te responderemos a la brevedad.';
        }

        return $respuesta;
    }
};
