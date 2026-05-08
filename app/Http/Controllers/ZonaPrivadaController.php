<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Descarga;
use App\Models\Contacto;
use App\Models\Pedido;
use App\Models\CarritoContenido;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\TipoArticulo;
use App\Models\Cliente;
use App\Mail\Carrito;
use App\Models\Articulo;
use stdClass;
use App\Models\Rede;
use App\Models\Logo;
use App\Models\PresentacionRelacion;
use App\Http\Controllers\Soap\Products;
use App\Jobs\EnviarPedidoJob;
use App\Models\Inicio;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ZonaPrivadaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.cliente');
    }

    public function index()
    {
        $inicio = Inicio::first();
        $active = 'page.home';
        $categorias = TipoArticulo::where('oculto', 'false')->orderBy('orden', 'ASC')->get();
        return view('ZonaPrivada.home', compact('active', 'categorias', 'inicio'));
    }

    public function productos($id)
    {
        $cantidad = session('cantidad', 0);
        $active = 'page.home';
        $productos = Articulo::where('id', $id)->get();
        $categoria = TipoArticulo::find($productos[0]->sub_categoria);
        $inicio = Inicio::first();
        return view('ZonaPrivada.productos', compact('active', 'categoria', 'productos', 'inicio', 'cantidad'));
    }

    public function productosSearch(Request $request, $id)
    {
        $active = 'page.home';

        $productos = Articulo::where(function ($query) use ($request) {
            $search = '%' . $request->search . '%';
            $query->where('code', 'like', $search)
                ->orWhere('description', 'like', $search)
                ->orWhere('name', 'like', $search)
                ->orWhere('codigoAnterior', 'like', $search)
                ->where('oculto', '=', 'false');
        })->get();

        if ($id == 0) {
            $producto = Articulo::where(function ($query) use ($request) {
                $search = '%' . $request->search . '%';
                $query->where('code', 'like', $search)
                    ->orWhere('description', 'like', $search)
                    ->orWhere('name', 'like', $search)
                    ->orWhere('codigoAnterior', 'like', $search)
                    ->where('oculto', '=', 'false');
            })->first();
            $categoria = $producto->ObtenerCategoria();
        } else {
            $categoria = TipoArticulo::find($id);
        }

        $inicio = Inicio::first();
        return view('ZonaPrivada.productos', compact('active', 'categoria', 'productos', 'inicio'));
    }

    public function carrito()
    {
        $active = 'page.carrito';
        $contactos = Contacto::where('seccion', '=', 'contacto')->orderBy('orden', 'ASC')->get();
        $carrito = Contacto::where('seccion', '=', 'carrito')->first();
        $redes = Rede::get();
        $inicio = Inicio::first();
        return view('ZonaPrivada.carrito', compact('contactos', 'active', 'redes', 'carrito', 'inicio'));
    }

    public function miperfil()
    {
        $active = 'page.mi.perfil';
        $user = Cliente::find(Auth::guard('cliente')->user()->id);
        $inicio = Inicio::first();
        return view('ZonaPrivada.miperfil', compact('active', 'user', 'inicio'));
    }

    public function listaPrecios()
    {
        $active = 'page.listadeprecios';
        $inicio = Inicio::first();
        $descargas = Descarga::orderBy('orden', 'ASC')->get();
        return view('ZonaPrivada.listaPrecios', compact('active', 'descargas', 'inicio'));
    }

    public function carritoPasoDos()
    {
        $active = 'page.carrito';
        $contactos = Contacto::where('seccion', '=', 'contacto')->orderBy('orden', 'ASC')->get();
        $redes = Rede::get();
        return view('ZonaPrivada.carritoPasoDos', compact('contactos', 'active', 'redes'));
    }

    public function carrito_post(Request $request)
    {
        $carritoPedido = json_decode($request->producto, true);
        $codigos = array_column($carritoPedido, 'codigo');
        $descuentoCliente = Auth::guard('cliente')->user()->descuento;

        // UNA sola query para todos los artículos, indexada por código
        $articulos = Articulo::whereIn('code', $codigos)
            ->get()
            ->keyBy('code');

        // Verificar stock en una sola pasada
        $productosSinStock = [];
        foreach ($carritoPedido as $item) {
            $prod = $articulos->get($item['codigo']);
            if (!$prod || $prod->{'stock-disponible'} <= 0) {
                $productosSinStock[] = $item['codigo'];
            }
        }

        if (!empty($productosSinStock)) {
            return response()->json([
                'error' => 'Los siguientes productos no tienen stock disponible: ' . implode(', ', $productosSinStock)
            ], 400);
        }

        // Procesar productos y calcular totales
        $arrCarrito = [];
        $total = 0;

        foreach ($carritoPedido as $item) {
            $prod = $articulos->get($item['codigo']);
            if (!$prod) continue;

            $subtotal = floatval($prod->precioVigente) * intval($item['cantidad']);

            if ($descuentoCliente) {
                $subtotal -= $subtotal * ($descuentoCliente / 100);
            }

            $total += $subtotal;

            $prodAux = new stdClass;
            $prodAux->codigo   = mb_convert_encoding($prod->code, 'UTF-8', mb_detect_encoding($prod->code, 'UTF-8, ISO-8859-1, ISO-8859-15', true));
            $prodAux->nombre   = mb_convert_encoding($prod->name, 'UTF-8', mb_detect_encoding($prod->name, 'UTF-8, ISO-8859-1, ISO-8859-15', true));
            $prodAux->cantidad = $item['cantidad'];
            $prodAux->precio   = $prod->precioVigente;
            $prodAux->subtotal = $subtotal;

            $arrCarrito[] = $prodAux;
        }

        // Guardar pedido
        $pedido = new Pedido;
        $pedido->fecha      = date('d/m/o');
        $pedido->usuario_id = Auth::guard('cliente')->user()->id;
        $pedido->total      = $total;
        $pedido->estado     = 'PENDIENTE';
        $pedido->pedido     = json_encode($arrCarrito);
        $pedido->save();

        $pedido_carrito = new stdClass;
        $pedido_carrito->id           = $pedido->id;
        $pedido_carrito->observacion  = $request->obeservacion;
        $pedido_carrito->pedido       = $arrCarrito;
        $pedido_carrito->usario       = Auth::guard('cliente')->user();
        $pedido_carrito->numeroPedido = $pedido->id;
        $pedido_carrito->email        = Auth::guard('cliente')->user()->email;
        $pedido_carrito->total_pedido = $total;

        $file = $request->file('file') !== null ? $request->file('file') : null;

        return response()->json([
            'mensaje' => 'Muchas gracias por su compra. En breve le llegará un e-mail con la confirmación del pedido',
            'pedido'  => $pedido_carrito,
            'archivo' => $file,
            'usuario' => Auth::guard('cliente')->user()
        ]);
    }

    public function enviarMails(Request $request)
    {
        Log::info('=== enviarMails INICIO ===', [
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'has_response' => $request->has('response'),
            'response_type' => gettype($request->response),
            'response_length' => is_string($request->response) ? strlen($request->response) : null,
        ]);

        $raw = $request->response;

        if (!$raw) {
            Log::error('enviarMails: no llegó response en el request', [
                'all_keys' => array_keys($request->all()),
            ]);

            return response()->json([
                'error' => 'No llegó response en el request'
            ], 422);
        }

        if (!mb_check_encoding($raw, 'UTF-8')) {
            Log::warning('enviarMails: raw no venía en UTF-8, convirtiendo...');
            $raw = mb_convert_encoding($raw, 'UTF-8', 'ISO-8859-1');
        }

        $data = json_decode($raw, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('enviarMails json_decode error: ' . json_last_error_msg(), [
                'raw_preview' => substr($raw, 0, 1000),
            ]);

            return response()->json([
                'error' => 'Error de encoding en los datos del pedido',
                'json_error' => json_last_error_msg(),
            ], 422);
        }

        Log::info('enviarMails: JSON decodificado correctamente', [
            'keys' => array_keys($data),
            'pedido_id' => $data['pedido']['id'] ?? null,
            'numeroPedido' => $data['pedido']['numeroPedido'] ?? null,
            'usuario_email' => $data['usuario']['email'] ?? null,
            'archivo_type' => isset($data['archivo']) ? gettype($data['archivo']) : null,
            'archivo_value' => $data['archivo'] ?? null,
        ]);

        if (empty($data['pedido'])) {
            Log::error('enviarMails: falta data[pedido]', ['data' => $data]);

            return response()->json([
                'error' => 'Faltan datos del pedido'
            ], 422);
        }

        if (empty($data['usuario'])) {
            Log::error('enviarMails: falta data[usuario]', ['data' => $data]);

            return response()->json([
                'error' => 'Faltan datos del usuario'
            ], 422);
        }

        try {
            EnviarPedidoJob::dispatch(
                $data['pedido'],
                $data['archivo'] ?? null,
                (object) $data['usuario']
            );

            Log::info('enviarMails: Job despachado correctamente', [
                'pedido_id' => $data['pedido']['id'] ?? null,
                'numeroPedido' => $data['pedido']['numeroPedido'] ?? null,
                'usuario_email' => $data['usuario']['email'] ?? null,
                'queue_connection' => config('queue.default'),
            ]);

            return response()->json([
                'message' => 'Job de correos despachado correctamente'
            ]);
        } catch (\Throwable $e) {
            Log::error('enviarMails: error al despachar job', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'error' => 'No se pudo despachar el job de correos'
            ], 500);
        }
    }

    public function carritoPasoDosPost(Request $request)
    {
        $active = 'page.carrito';
        $pedido = new Pedido;
        $pedido->fecha      = date('d/m/o');
        $pedido->estado     = 'pendiente';
        $pedido->observacion = $request->observacion;
        $pedido->envio      = $request->envio;
        $pedido->cliente    = Auth::guard('cliente')->user()->id;

        $carrito = [];
        $Products = new Products;

        for ($i = 0; $i < count($request->nombre); $i++) {
            $articulo = new stdClass;
            $articuloAux = Articulo::where('code', '=', $request->codigo[$i])->first();
            $articulo->productId  = $articuloAux->productId;
            $articulo->nombre     = $request->nombre[$i];
            $articulo->codigo     = $request->codigo[$i];
            $articulo->cantidad   = number_format($request->cantidad[$i], 2);
            $articulo->precio     = $request->precio[$i];
            $promotion = $Products->applyPromotion($articulo);
            $articulo->FinalPrice    = strVal($promotion['FinalPrice']);
            $articulo->Discount      = strVal($promotion['Discount']);
            $articulo->DiscountValue = strVal($promotion['DiscountValue']);
            $articulo->DiscountType  = strVal($promotion['DiscountType']);
            array_push($carrito, $articulo);
        }

        $pedido->carrito = json_encode($carrito);
        $order = $Products->addPedido($carrito, Auth::guard('cliente')->user(), $request->envio);
        $CustomerId = Auth::guard('cliente')->user()->CustomerId;

        if ($CustomerId || $CustomerId == "") {
            $Products->addCustomer(Auth::guard('cliente')->user());
        }

        $pedido->OrderId      = $order->orderId;
        $pedido->OrderNumber  = $order->orderNumber;
        $pedido->CustomerId   = $CustomerId;
        $pedido->save();

        return $pedido;
    }

    public function comprar(Request $request)
    {
        $contacto    = Contacto::first();
        $carrito     = CarritoContenido::first();
        $active      = 'page.carrito';
        $logosheader = Logo::where('seccion', 'header')->orderBy('id', 'ASC')->get();
        $logosfooter = Logo::where('seccion', 'footer')->first();
        $contactos   = Contacto::where('seccion', '=', 'contacto')->orderBy('orden', 'ASC')->get();
        $redes       = Rede::get();

        $pedido = new Pedido;
        $pedido->fecha  = date('d/m/o');
        $pedido->estado = 'pendiente';

        $arr_carrito = [];
        $total  = $request->total_pedido;
        $string = "";

        for ($i = 0; $i < count($request->producto); $i++) {
            $prod = Producto::find($request->producto[$i]);
            if ($prod) {
                $carritoEmail         = new stdClass;
                $carritoEmail->nombre   = $prod->obtenerCategoria->obtenerProductoCategoria->nombre . " " . $prod->obtenerCategoria->nombre;
                $carritoEmail->codigo   = $prod->codigo;
                $carritoEmail->precio   = $prod->precio;
                $carritoEmail->id       = $prod->id;
                $carritoEmail->cantidad = $request->cantidad[$i];
                array_push($arr_carrito, $carritoEmail);
                $total  += floatval($prod->precio) * intval($request->cantidad[$i]);
                $string .= "Producto: " . $prod->codigo . " / " . $prod->descripcion . "  / cant" . $request->cantidad[$i] . " / " . $prod->precio . "----";
            }
        }

        $carrito_pedido     = json_encode($arr_carrito);
        $pedido->usuario_id = Auth::guard('cliente')->user()->id;
        $pedido->total      = $total;
        $pedido->pedido     = $carrito_pedido;

        $pedido_carrito               = new stdClass;
        $pedido_carrito->mensaje      = $request->msj;
        $pedido_carrito->pedido       = $string;
        $pedido_carrito->orden        = "";
        $pedido_carrito->entrega      = $request->envio;
        $pedido_carrito->pago         = $request->pago;
        $pedido_carrito->nombre       = $request->nombre;
        $pedido_carrito->dni          = $request->dni;
        $pedido_carrito->email        = $request->email;
        $pedido_carrito->celular      = $request->celular;
        $pedido_carrito->direccion    = $request->direccion;
        $pedido_carrito->localidad    = $request->localidad;
        $pedido_carrito->provincia    = $request->provincia;
        $pedido_carrito->cp           = $request->cp;
        $pedido_carrito->totalCarrito = $request->totalCarrito;
        $pedido_carrito->otro         = $request->otro ? "Si" : "No";
        $pedido_carrito->total_pedido = $total;

        $file  = $request->file('file') !== null ? $request->file('file') : null;
        $email = new Carrito($pedido_carrito, $file);

        Mail::to($contacto->correo)->bcc(Auth::guard('cliente')->user()->email)->send($email);

        $pedido->save();

        return view('ZonaPrivada.carrito_fin', compact('contactos', 'carrito', 'active', 'logosheader', 'logosfooter', 'redes'));
    }

    public function historico(Request $request)
    {
        $active = 'page.historial';
        $id     = Auth::guard('cliente')->user()->id;
        $pedido = DB::table('pedidos')->where('usuario_id', '=', $id)->orderBy('id', 'desc')->get();

        foreach ($pedido as $item) {
            $item->pedido = json_decode($item->pedido);
        }

        $inicio = Inicio::first();
        return view('ZonaPrivada.historico', compact('active', 'pedido', 'inicio'));
    }

    public function facturas()
    {
        $active      = 'page.facturas';
        $logosheader = Logo::where('seccion', 'header')->orderBy('id', 'ASC')->get();
        $logosfooter = Logo::where('seccion', 'footer')->first();
        $contactos   = Contacto::where('seccion', '=', 'contacto')->orderBy('orden', 'ASC')->get();
        $redes       = Rede::get();

        $id    = Auth::guard('cliente')->user()->id;
        $pedido = Pedido::where('usuario_id', '=', $id)
            ->where('estado', '=', 'FACTURADO')
            ->OrWhere('estado', '=', 'FACTURADO PENDIENTES')
            ->orderBy('id', 'desc')->get();

        return view('ZonaPrivada.facturas', compact('contactos', 'active', 'logosheader', 'logosfooter', 'redes', 'pedido'));
    }

    public function buscar(Request $request)
    {
        $active      = 'page.pedido';
        $logosheader = Logo::where('seccion', 'header')->orderBy('id', 'ASC')->get();
        $logosfooter = Logo::where('seccion', 'footer')->first();
        $categorias  = Categoria::orderBy('orden', 'ASC')->get();
        $productos   = Producto::where('activa', '!=', 0)->get();
        $contactos   = Contacto::where('seccion', '=', 'contacto')->orderBy('orden', 'ASC')->get();
        $redes       = Rede::get();
        $carrito     = CarritoContenido::first();

        if ($request->producto) {
            $productos = Producto::where('nombre', 'LIKE', "%$request->producto%")->where('activa', '!=', 0)->get();
        }

        if ($request->categoria != 0) {
            $productos = $productos->where('categorias_id', $request->categoria)->where('activa', '!=', 0);
        }

        if ($request->codigo) {
            $productos    = array();
            $presentacion = PresentacionRelacion::where('codigo', 'LIKE', $request->codigo)->get();
            foreach ($presentacion as $item) {
                $producto = $item->obtenerProducto;
                if ($producto && $producto->activa != 0) {
                    array_push($productos, $producto);
                }
            }
        }

        $buscador = 1;
        return view('ZonaPrivada.productoPedidoSearch', compact('logosheader', 'logosfooter', 'contactos', 'active', 'redes', 'categorias', 'productos', 'carrito', 'buscador'));
    }

    public function recomprar(Request $request)
    {
        $pedido    = Pedido::find($request->id);
        $carrito   = CarritoContenido::first();
        $arrPedido = json_decode($pedido->pedido);

        $arrPedidoAux = [];
        $string       = "";
        $total_pedido = 0;

        foreach ($arrPedido as $item) {
            $presentacion = PresentacionRelacion::find($item->presentacionid);
            $precio       = floatval($presentacion->precio);

            $string       .= "Producto: " . $item->nombre . " codigo: " . $item->codigo . " cantidad: " . $item->cantidad . " precio: $ " . $precio;
            $total_pedido += $precio * intval($item->cantidad);
            $item->precio  = $precio;

            $itemAux               = new stdClass;
            $itemAux->codigo       = $item->codigo;
            $itemAux->nombre       = $item->nombre;
            $itemAux->precio       = $precio;
            $itemAux->presentacionid = $item->presentacionid;
            $itemAux->stock        = $item->stock;
            $itemAux->id           = $item->id;
            $itemAux->cantidad     = $item->cantidad;
            $itemAux->idPedido     = $item->idPedido;
            $itemAux->imagen       = $item->imagen;
            array_push($arrPedidoAux, $itemAux);
        }

        $descuento = 1;
        if (Auth::guard('cliente')->user()->descuento != 0 || Auth::guard('cliente')->user()->descuento != null) {
            $descuento = (100 - Auth::guard('cliente')->user()->descuento) / 100;
        }

        $iva         = ($carrito->iva / 100) + 1;
        $totalIva    = ($total_pedido * $descuento) * $iva;

        $newPedido           = new Pedido();
        $newPedido->usuario_id = $pedido->usuario_id;
        $newPedido->fecha    = date('d/m/o');
        $newPedido->estado   = "pendiente";
        $newPedido->total    = $totalIva;
        $newPedido->pedido   = json_encode($arrPedidoAux);
        $newPedido->save();

        $pedido_carrito          = new stdClass;
        $pedido_carrito->mensaje = $request->obeservacion;
        $pedido_carrito->pedido  = $string;
        $pedido_carrito->entrega = $request->entrega;

        if ($request->entregaconvenir) {
            $pedido_carrito->entregatext = $request->entregaconvenir;
        }

        $pedido_carrito->email        = Auth::guard('cliente')->user()->email;
        $pedido_carrito->total_pedido = $total_pedido;

        $file    = $request->file('file') !== null ? $request->file('file') : null;
        $email   = new Carrito($pedido_carrito, $file);
        $contacto = Contacto::first();

        Mail::to($contacto->correo)->bcc(Auth::guard('cliente')->user()->email)->send($email);

        return $request->all();
    }

    public function lista()
    {
        $active      = 'page.lista';
        $logosheader = Logo::where('seccion', 'header')->orderBy('id', 'ASC')->get();
        $logosfooter = Logo::where('seccion', 'footer')->first();
        $contactos   = Contacto::where('seccion', '=', 'contacto')->orderBy('orden', 'ASC')->get();
        $listas      = Descarga::orderBy('orden', 'ASC')->get();
        $redes       = Rede::get();

        return view('ZonaPrivada.lista', compact('logosheader', 'logosfooter', 'contactos', 'active', 'redes', 'listas'));
    }
}
