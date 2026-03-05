<?php



namespace App\Http\Controllers\Admin;



use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Mail\PedidoPendienteMail;

use App\Models\Articulo;

use App\Models\Cliente;

use App\Models\Metrica;

use Carbon\Carbon;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Validator;

use Illuminate\Validation\Rule;



class MetricasController extends Controller

{



    public function datos(Request $request)

    {

        $clienteId = $request->input('cliente_id');

        $productoId = $request->input('producto_id'); // En este caso lo dejamos opcional

        $fechaDesde = $request->input('fecha_desde');

        $fechaHasta = $request->input('fecha_hasta');

    

        $query = Metrica::query();

        

        if ($clienteId) {

            $query->where('cliente_id', $clienteId);

        }

        if ($productoId) {

            $query->where('producto_id', $productoId);

        }

        if ($request->filled('fecha_desde') && $request->filled('fecha_hasta')) {

            $desde = Carbon::parse($fechaDesde)->startOfDay();

            $hasta = Carbon::parse($fechaHasta)->endOfDay();

            $query->whereBetween('fecha', [$desde, $hasta]);

        }

        

        // Filtramos solo los dos tipos de eventos

        $query->whereIn('tipo_evento', ['add_to_cart', 'remove_from_cart']);

    

        // Realizamos un join con la tabla de artículos para obtener el nombre del producto

        $data = $query->join('articulos as a', 'metricas.producto_id', '=', 'a.id')

            ->selectRaw("DATE(metricas.fecha) as fecha, a.code as product_name, tipo_evento, SUM(metricas.cantidad) as total")

            ->groupBy('fecha', 'a.code', 'tipo_evento')

            ->orderBy('fecha','asc')

            ->get();

    

        // Pivot: Creamos categorías compuestas "fecha - producto"

        $pivot = [];

        foreach ($data as $row) {

            $category = $row->product_name;

            if (!isset($pivot[$category])) {

                $pivot[$category] = ['add_to_cart' => 0, 'remove_from_cart' => 0];

            }

            $pivot[$category][$row->tipo_evento] = $row->total;

        }

    

        // Sólo incluimos categorías donde al menos uno de los valores es mayor a 0

        $categories = [];

        $addSeries = [];

        $removeSeries = [];

        foreach ($pivot as $category => $values) {

            if ($values['add_to_cart'] == 0 && $values['remove_from_cart'] == 0) {

                continue;

            }

            $categories[] = $category;

            $addSeries[] = $values['add_to_cart'];

            $removeSeries[] = $values['remove_from_cart'];

        }

    

        return response()->json([

            'categories' => $categories,

            'addSeries'  => $addSeries,

            'removeSeries' => $removeSeries

        ]);

    }

    



    public function store(Request $request)

    {

        // Validamos los datos recibidos. Se agregan los campos 'lapso' y 'enviar_mail'

        $data = $request->validate([

            'cliente_id'   => 'nullable|integer',

            'producto_id'  => 'nullable|integer',

            'cantidad'     => 'nullable|integer', // Puede ser null en eventos sin cantidad

            'tipo_evento'  => 'required|string|max:50',

            'fecha'        => 'required|date',

            'referrer'     => 'nullable|string|max:255',

            'lapso'        => 'nullable|in:24,48',     // Indica el lapso del abandono, en horas

            'enviar_mail'  => 'nullable'         // True para enviar email, false en caso contrario

        ]);

    

        // Convertimos la fecha a la zona horaria deseada.

        $data['fecha'] = Carbon::parse($data['fecha'])

                        ->setTimezone('America/Argentina/Buenos_Aires')

                        ->toDateTimeString();

    

        // Si el evento es de carrito abandonado...

        if ($data['tipo_evento'] === 'pedido_cancelado') {

            $cliente = null;

            if (isset($data['cliente_id'])) {

                // Obtenemos el cliente (asumiendo que el modelo Cliente existe y tiene 'email')

                $cliente = Cliente::find($data['cliente_id']);

            }

    

            // Si es un abandono a 24hs:

            if (isset($data['lapso']) && $data['lapso'] == 24) {

                // Enviar mail si el flag enviar_mail es verdadero y se encontró el cliente.

                if (!empty($data['enviar_mail']) && $cliente) {

                    Mail::to($cliente->email)

                        ->send(new PedidoPendienteMail($cliente, 24));

                }

                // No guardamos el evento, sólo respondemos.

                return response()->json([

                    'mensaje' => 'Evento de abandono de carrito a 24 hs procesado (sin guardar).'

                ], 200);

            }

            // Si es un abandono a 48hs:

            elseif (isset($data['lapso']) && $data['lapso'] == 48) {

                // Enviar mail si corresponde.

                if (!empty($data['enviar_mail']) && $cliente) {

                    Mail::to($cliente->email)

                        ->send(new PedidoPendienteMail($cliente, 48));

                }

                // Guardamos el evento en la base de datos

                $evento = Metrica::create($data);

    

                return response()->json([

                    'mensaje' => 'Evento de abandono de carrito a 48 hs guardado y mail enviado.',

                    'evento'  => $evento

                ], 201);

            }

        }

    

        // Para otros tipos de evento se realiza el guardado de forma normal

        $evento = Metrica::create($data);

    

        return response()->json([

            'mensaje' => 'Evento guardado correctamente',

            'evento'  => $evento

        ], 201);

    }

    





    public function clientes(Request $request)

    {

        $tipo = $request->get('tipo_evento');

    

        $tiposEvento = $tipo === 'add_to_cart'

            ? ['add_to_cart', 'remove_to_cart']

            : [$tipo];

    

        $clientesIds = Metrica::whereNotNull('cliente_id')

                        ->whereIn('tipo_evento', $tiposEvento)

                        ->distinct()

                        ->pluck('cliente_id');

    

        Log::info("Tipo evento recibido: $tipo");

        Log::info("Tipos usados para filtrado: ", $tiposEvento);

        Log::info("Clientes IDs: ", $clientesIds->toArray());

    

        $clientes = Cliente::whereIn('id', $clientesIds)

                        ->select('id', 'razonSocial as name')

                        ->get();

    

        return response()->json($clientes);

    }

    

    

    

    public function productos()

    {

        // Obtenemos los IDs de productos que tienen registros en metricas

        $productosIds = Metrica::whereNotNull('producto_id')

                          ->distinct()

                          ->pluck('producto_id');

    

        // Suponiendo que tienes un modelo Producto con un campo 'name'

        $productos = Articulo::whereIn('id', $productosIds)

                          ->select('id', 'name')

                          ->get();

    

        return response()->json($productos);

    }





    public function datosPedidosCancelados(Request $request)

{

    // Recibimos filtros opcionales

    $clienteId = $request->input('cliente_id');

    $fechaDesde = $request->input('fecha_desde');

    $fechaHasta = $request->input('fecha_hasta');



    // Creamos la consulta base

    $query = Metrica::query();



    if ($clienteId) {

        $query->where('cliente_id', $clienteId);

    }

    // Filtro por rango de fechas si se envían ambos parámetros

    if ($request->filled('fecha_desde') && $request->filled('fecha_hasta')) {

        $desde = Carbon::parse($fechaDesde)->startOfDay()->toDateTimeString();

        $hasta = Carbon::parse($fechaHasta)->endOfDay()->toDateTimeString();

        $query->whereBetween('fecha', [$desde, $hasta]);

    }



    // Filtramos para obtener solo registros de pedido_cancelado

    $query->where('tipo_evento', 'pedido_cancelado');



    // Agrupamos por la fecha y sumamos la cantidad

    $data = $query->selectRaw("DATE(fecha) as fecha, SUM(cantidad) as total")

    ->groupByRaw("DATE(fecha)")

    ->orderByRaw("DATE(fecha) ASC")

    ->get();





    $dataDates = [];

    $cancelTotals = [];

    foreach ($data as $row) {

        $dataDates[] = $row->fecha;

        $cancelTotals[$row->fecha] = $row->total;

    }



    // Generamos un rango continuo de fechas según el filtro (o a partir de los datos si no se filtra)

    if ($request->filled('fecha_desde') && $request->filled('fecha_hasta')) {

        $start = Carbon::parse($fechaDesde);

        $end = Carbon::parse($fechaHasta);

    } else {

        if (count($dataDates) > 0) {

            $start = Carbon::parse(min($dataDates));

            $end = Carbon::parse(max($dataDates));

        } else {

            return response()->json([

                'dates' => [],

                'cancelSeries' => []

            ]);

        }

    }



    $allDates = [];

    for ($date = $start->copy(); $date->lte($end); $date->addDay()) {

        $allDates[] = $date->format('Y-m-d');

    }



    $cancelSeries = [];

    foreach ($allDates as $date) {

        $cancelSeries[] = $cancelTotals[$date] ?? 0;

    }



  



    return response()->json([

        'dates' => $allDates,

        'cancelSeries' => $cancelSeries

    ]);

}



public function datosReferrer(Request $request)

{

    // Recibimos filtros opcionales: por cliente y rango de fechas

    $clienteId = $request->input('cliente_id');

    $fechaDesde = $request->input('fecha_desde');

    $fechaHasta = $request->input('fecha_hasta');



    $query = Metrica::query();



    if ($clienteId) {

        $query->where('cliente_id', $clienteId);

    }

    if ($request->filled('fecha_desde') && $request->filled('fecha_hasta')) {

        $desde = Carbon::parse($fechaDesde)->startOfDay()->toDateTimeString();

        $hasta = Carbon::parse($fechaHasta)->endOfDay()->toDateTimeString();

        $query->whereBetween('fecha', [$desde, $hasta]);

    }



    // Filtramos para obtener solo registros de tipo 'referrer'

    $query->where('tipo_evento', 'cliente_referrer');



    // Agrupamos por el campo referrer y contamos la cantidad de registros para cada uno

    $data = $query->selectRaw("referrer, COUNT(*) as total")

                  ->groupBy('referrer')

                  ->orderBy('total', 'desc')

                  ->get();



    // Preparamos arrays para los referrers y sus totales

    $referrers = [];

    $totals = [];

    foreach ($data as $row) {

        // Puedes filtrar registros vacíos o nulos si lo deseas

        if (!empty($row->referrer)) {

            $referrers[] = $row->referrer;

            $totals[] = $row->total;

        }

    }



    \Log::info('Datos referrer:', $data->toArray());





    return response()->json([

        'referrers' => $referrers,

        'totals' => $totals,

    ]);

}





    

}

