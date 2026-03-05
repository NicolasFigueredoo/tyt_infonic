<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Articulo;
use App\Models\Cliente;
use App\Models\TipoArticulo;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class TipoArticuloController extends Controller {
    private $model = TipoArticulo::class;
    private $name = 'Tipo Articulo';
    private $prefixPermission = 'tipo_articulo';

    public function all()
    {
        $data = $this->model::query();

        // Aplicar los filtros si existen
        if (request()->has('filters') && is_array(request()->filters)) {
            foreach (request()->filters as $key => $value) {
                $data->where($key, 'like', '%' . $value . '%');
            }
        }

        // Ordenar primero por aquellos que tienen valor en 'orden', y luego los vacíos al final
        $data->orderByRaw("CASE WHEN orden IS NULL OR orden = '' THEN 1 ELSE 0 END, orden ASC");

        return $data->paginate(100);
    }

    // Sincroniza categorías y subcategorías desde el ERP externo.
    // Llamar manualmente desde el admin cuando se necesite actualizar, NO automáticamente.
    public function sincronizarCategorias()
    {
        $client = new Client();
        $apiUrlBase = 'https://tytsaapi.ddns.net:8443/productos?maxCount=100&page=';
        $totalPages = 8;

        try {
            for ($page = 0; $page <= $totalPages; $page++) {
                $apiUrl = $apiUrlBase . $page;

                $respuesta = $client->request('GET', $apiUrl, [
                    'headers' => [
                        'X-Api-Key' => 'AQEBEQtz8rVkLVvBKgmYuUmALBpS5GaLG28OUFpd3O08GlfjWrjH3wWt5Hk0GEra5MsMseWHtdise8FGiu3P7iNjEocjzW2T+IJ7c9TH0rbf17trDAc8qK4mAgvv3AMcu5CjuDwzR+9qS1uF5ZZwUNN/FFgD8HRRgkik86XZfttYSPK68RpnFSBrT2XDUTeXvcOdjTjzH7AwJDHj+o9WwskXIQT7Ubgj+oAaTjd4Obq+uyObg75n033Ct5ZO53JTHsvCDfbcMU1BtRtw4CvFynEPiEQ7rufWnDThqJQKqfLvSgBjr2c3L3QV8EKvuNsnNO9vQGrZbuY58sMTXGmMio1iTUxwrnOPpsCO9L4Jr1Onwgu+bIStiJcS2w/3hbzVWR2yo1YWvW0LjJquBNx1I46aUCiw82jHAffI788rrNNuYA8='
                    ],
                    'verify' => false
                ]);

                $productos = json_decode($respuesta->getBody(), true);

                foreach ($productos['values'] as $value) {
                    $articulo = Articulo::where('code', $value['codigoProducto'])->first();

                    if ($articulo) {
                        // Normalizar y actualizar categoría principal
                        if ($value['unidadNegocio']) {
                            $unidadNegocio = mb_strtolower($value['unidadNegocio'], 'UTF-8');
                            $unidadNegocio = str_replace(
                                ['á', 'é', 'í', 'ó', 'ú', 'ñ'],
                                ['a', 'e', 'i', 'o', 'u', 'n'],
                                $unidadNegocio
                            );
                            $categoria = TipoArticulo::whereRaw('LOWER(name) = ?', [$unidadNegocio])->first();

                            if (!$categoria) {
                                $categoria = new TipoArticulo();
                            }
                            $categoria->name = strtoupper($value['unidadNegocio']);
                            $categoria->principal = 'true';
                            $categoria->save();
                        }

                        // Normalizar y actualizar subcategoría
                        if ($value['familiaWeb']) {
                            $familiaWeb = mb_strtolower($value['familiaWeb'], 'UTF-8');
                            $familiaWeb = str_replace(
                                ['á', 'é', 'í', 'ó', 'ú', 'ñ'],
                                ['a', 'e', 'i', 'o', 'u', 'n'],
                                $familiaWeb
                            );
                            $subCategoria = TipoArticulo::whereRaw('LOWER(name) = ?', [$familiaWeb])->first();

                            if (!$subCategoria) {
                                $subCategoria = new TipoArticulo();
                            }
                            $subCategoria->name = strtoupper($value['familiaWeb']);
                            $subCategoria->sub_categoria_id = $categoria->id ?? null;
                            $subCategoria->save();
                        }
                    }
                }
            }

            return response()->json(['message' => 'Categorías sincronizadas correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al sincronizar categorías: ' . $e->getMessage()], 500);
        }
    }

    public function find($id) { 

        $categorias = $this->model::all();
        $articulos = Articulo::where('oculto', '=', 'false')->get();


        if($id == 0){
            return response()->json([
                'categorias' => $categorias,
                'productos' => $articulos


            ]);  
        }
        $item = $this->model::find($id);
        
        
        $articulosVinculados = $item->productos;

    
    
    
    
    
    
    

        if($item->id == 36 || $item->id == 37 || $item->id == 38){

            if ($item) {
                return response()->json([
                    'item' => $item,
                    'productos' => $articulos,
                    'articulosVinculados' => $articulosVinculados

                ]);        }



        }else{

            if ($item) {
                return response()->json([
                    'item' => $item,
                    'categorias' => $categorias,
                    'productos' => $articulos,
                    'articulosVinculados' => $articulosVinculados


                ]);  
        }}

        return response()->json(['message' => $this->name . ' not found'], 404);
    }

    public function store(Request $request, $id = null) {
        // validate the request
        
        $request->validate([
            'name' => 'required|string|max:255',
        ]);


        // store a new item
        if ($id && ! $request->has('__form-input-copy') ) {
            $item = $this->model::find($id);
        } else {
            $item = new $this->model;
        }
        $item->name = $request->name;
        $item->nameEnglish = $request->nameEnglish;
        $item->orden = $request->orden;
        $item->code = $request->code;
        $item->destacado = $request->destacado ?? 'false';
        $item->oculto = $request->oculto ?? 'false';
        $item->principal = $request->principal ?? 'false';


        $item->sub_categoria_id = $request->sub_categoria_id;



        
        if ($request->hasFile('imagenSrc')){
            File::delete(public_path('inicio/'.$item->imagen));

            $file = $request->file('imagenSrc');
            $nombreImagen = 'media_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('storage/inicio/', $nombreImagen);
            $item->imagen  = 'inicio/' . $nombreImagen;

        }

        if ($request->hasFile('imagenMarca')){
            File::delete(public_path('inicio/'.$item->imagenMarca));

            $file = $request->file('imagenMarca');
            $nombreImagen = 'media_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('storage/inicio/', $nombreImagen);
            $item->imagenMarca  = 'inicio/' . $nombreImagen;

        }
            
        
        $item->save();


        $productosSeleccionados = $request->productos;
        $productos = json_decode($productosSeleccionados, true);

        // Verifica que se haya decodificado correctamente
        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'Error al decodificar los productos'], 400);
        }
        


      if(count($productos) > 0){
        $item->productos()->detach();


          foreach ($productos as $producto) {
              $existingProducto = Articulo::find($producto['id']);
              if ($existingProducto) {
                  $existingProducto->categorias()->syncWithoutDetaching($item->id);
              }
          }
      }


        return $item;
    }
    public function ocultar($id) {
        $item = $this->model::find($id);
        if ($item) {
            if($item->oculto == 'true'){
                $item->oculto = 'false';
            }else{
                $item->oculto = 'true';
            }
            $item->save();
            return $item;
        }
        //abort(500, 'El registro que intenta eliminar no existe');
    }
    public function delete($id) {
        
        $item = $this->model::find($id);
        $articulosVinculados = Articulo::where('sub_categoria', $item->id)->where('oculto', '=', 'false')->get();

        foreach ($articulosVinculados as $producto) {
     
                $producto->sub_categoria = null;
                $producto->save();
            
        }
        
        $item->delete();

        
        return $item;
    }

    public function restore($id) {
        $item = $this->model::withTrashed()->find($id);
        $item->restore();
        return $item;
    }

    public function destroy($id) {
        $item = $this->model::withTrashed()->find($id);
        $item->forceDelete();
        return $item;
    }

    public function listSelect(Request $request) {
        $data = $this->model::orderBy('id', 'asc');
        if ( request()->has('search') && strlen(request()->search) ) {
            $data->where(function($query) {
                $keys = ['name'];
                foreach ($keys as $key => $colName) {
                    $query->orWhere($colName, 'like', '%'.request()->search.'%');
                }
            });
        }
        if ( request()->has('optionKey') ) {
            $data->where('id', request()->optionKey);
            return $data->first();
        }
        return $data->paginate();
    }

    public function subcategorias(Request $request)
    {
        $categoriaId = $request->input('categoriaId'); 
        $categoriaSelect = $request->input('categoriaSelect');  

        $subcategorias = TipoArticulo::where('sub_categoria_id', $categoriaId)->where('oculto', 'false')->get();

        $productoRoute = $request->productoRoute;

    
        return view('partials.subcategoria', compact('subcategorias', 'categoriaId', 'categoriaSelect', 'productoRoute'))->render();
        
    }

    public function categorias()
    {
        $categorias = $this->model::all();
        $productos = Articulo::all();

        return response()->json([
            'categorias' => $categorias,
            'productos' => $productos

        ]);         
    }
    public function generarCodigoAlfabetico($index) {
        $letras = range('a', 'z');
        $primerLetra = $letras[intdiv($index, 26)];
        $segundaLetra = $letras[$index % 26];
    
        return $primerLetra . $segundaLetra;
    }

     function cargaProductos(){
        {
            $client = new Client();
            $apiUrl = 'https://tytsaapi.ddns.net:8443/productos?maxCount=100&page=4'; // Asegúrate de que la URL sea correcta
            
            try {
                // Hacer una solicitud a la API
                $respuesta = $client->request('GET', $apiUrl, [
                    'headers' => [
                        'X-Api-Key' => 'AQEBEQtz8rVkLVvBKgmYuUmALBpS5GaLG28OUFpd3O08GlfjWrjH3wWt5Hk0GEra5MsMseWHtdise8FGiu3P7iNjEocjzW2T+IJ7c9TH0rbf17trDAc8qK4mAgvv3AMcu5CjuDwzR+9qS1uF5ZZwUNN/FFgD8HRRgkik86XZfttYSPK68RpnFSBrT2XDUTeXvcOdjTjzH7AwJDHj+o9WwskXIQT7Ubgj+oAaTjd4Obq+uyObg75n033Ct5ZO53JTHsvCDfbcMU1BtRtw4CvFynEPiEQ7rufWnDThqJQKqfLvSgBjr2c3L3QV8EKvuNsnNO9vQGrZbuY58sMTXGmMio1iTUxwrnOPpsCO9L4Jr1Onwgu+bIStiJcS2w/3hbzVWR2yo1YWvW0LjJquBNx1I46aUCiw82jHAffI788rrNNuYA8=', // Ajusta según la clave que necesitas usar
                    ],
                    'verify' => false, // Solo si estás usando un certificado autofirmado
                ]);

                $index = 0;

                $productos = json_decode($respuesta->getBody(), true); // Ajusta según la estructura de la respuesta
                // dd($productos['values']);
                foreach ($productos['values'] as $value) {
                    
                    
                    
                $categoria = TipoArticulo::where('name', $value['unidadNegocio'])->where('principal', 'true')->first();

                if (!$categoria) {
                    $categoria = new TipoArticulo();
                    $categoria->name = $value['unidadNegocio'];
                    $categoria->principal = 'true';
                    $categoria->save();
                }else{
                    $categoria->name = $value['unidadNegocio'];
                    $categoria->principal = 'true';
                    $categoria->save();
                }


                $subCategoria = TipoArticulo::where('name', $value['familiaWeb'])->where('principal', 'false')->first();

                if (!$subCategoria) {
                    $subCategoria = new TipoArticulo();
                    $subCategoria->name = $value['familiaWeb'];
                    $subCategoria->principal = 'false';
                    $subCategoria->code = $value['tipoProducto'];
                    $subCategoria->sub_categoria_id = $categoria->id;
                    $subCategoria->save();
                }else{
                    $subCategoria->name = $value['familiaWeb'];
                    $subCategoria->principal = 'false';
                    $subCategoria->code = $value['tipoProducto'];
                    $subCategoria->sub_categoria_id = $categoria->id;
                    $subCategoria->save();
                }





                $articulo = Articulo::where('code', $value['codigoProducto'])->first();
                

                if($articulo){
                    $articulo->code = $value['codigoProducto'];
                    $articulo->codigoAnterior = $value['codigoAnterior'];
                    $articulo->tipoProducto = $value['tipoProducto'];
                    $articulo->name = $value['productoDescripcion'];
                    $articulo->description = $value['tipoDescripcion'];
                    $articulo->precioVigente = $value['precioVigente'];
                    $articulo->{'stock-disponible'} = $value['disponible'];
                    $articulo->bultoMinorista = $value['bultoMinorista'];
                    $articulo->bultoMayorista = $value['bultoMayorista'];
                    $articulo->sub_categoria = $subCategoria->id;
                    $articulo->categorias()->syncWithoutDetaching($subCategoria->id);
                    $articulo->marca = $value['marca'];
                    $articulo->orden = $this->generarCodigoAlfabetico($index);
                    $index++;
                    $articulo->save();
                }else{
                    $articulo = new Articulo();
                    $articulo->code = $value['codigoProducto'];
                    $articulo->codigoAnterior = $value['codigoAnterior'];
                    $articulo->orden = $this->generarCodigoAlfabetico($index);
                    $index++;
                    $articulo->tipoProducto = $value['tipoProducto'];
                    $articulo->name = $value['productoDescripcion'];
                    $articulo->description = $value['tipoDescripcion'];
                    $articulo->precioVigente = $value['precioVigente'];
                    $articulo->{'stock-disponible'} = $value['disponible'];
                    $articulo->bultoMinorista = $value['bultoMinorista'];
                    $articulo->bultoMayorista = $value['bultoMayorista'];
                    $articulo->sub_categoria = $subCategoria->id;
                    $articulo->categorias()->syncWithoutDetaching($subCategoria->id);
                    $articulo->marca = $value['marca'];
                    $articulo->save();

                }

                    
                }
              
    
                return response()->json(['message' => 'Carga masiva completada']);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Error al obtener productos: ' . $e->getMessage()], 500);
            }
        }
    }

    function cargaClientes() {
        $client = new Client();
        $baseApiUrl = 'https://tytsaapi.ddns.net:8443/clientes?maxCount=100&page='; // Base URL
        
        
        $clientesCreados = 0;
        $clientesActualizados = 0;
    
        try {
            
            for ($page = 0; $page <= 8; $page++) {
               
                $apiUrl = $baseApiUrl . $page;
    
              
                $respuesta = $client->request('GET', $apiUrl, [
                    'headers' => [
                        'X-Api-Key' => 'AQEBEQtz8rVkLVvBKgmYuUmALBpS5GaLG28OUFpd3O08GlfjWrjH3wWt5Hk0GEra5MsMseWHtdise8FGiu3P7iNjEocjzW2T+IJ7c9TH0rbf17trDAc8qK4mAgvv3AMcu5CjuDwzR+9qS1uF5ZZwUNN/FFgD8HRRgkik86XZfttYSPK68RpnFSBrT2XDUTeXvcOdjTjzH7AwJDHj+o9WwskXIQT7Ubgj+oAaTjd4Obq+uyObg75n033Ct5ZO53JTHsvCDfbcMU1BtRtw4CvFynEPiEQ7rufWnDThqJQKqfLvSgBjr2c3L3QV8EKvuNsnNO9vQGrZbuY58sMTXGmMio1iTUxwrnOPpsCO9L4Jr1Onwgu+bIStiJcS2w/3hbzVWR2yo1YWvW0LjJquBNx1I46aUCiw82jHAffI788rrNNuYA8=', // Ajusta según la clave que necesitas usar
                    ],
                    'verify' => false, 
                ]);
    
                $productos = json_decode($respuesta->getBody(), true); 
    
                foreach ($productos['values'] as $value) {
                    $cuenta = $value['cuenta'];
                    $razonSocial = $value['razonSocial'];
                    $direccion = $value['direccion'];
                    $provincia = $value['provincia'];
                    $codigoVendedor = $value['codigoVendedor'];
                    $vendedorDescripcion = $value['vendedorDescripcion'];
                    $codigoBonificacion = $value['codigoBonificacion'];
                    $bonificacionDescripcion = $value['bonificacionDescripcion'];
    
                    // Buscar cliente por cuenta
                    $cliente = Cliente::where('cuenta', $cuenta)->first(); // Cambié get() a first()
    
                    if ($cliente) {
                        // Si el cliente existe, actualiza sus datos
                        $cliente->razonSocial = $razonSocial;
                        $cliente->direccion = $direccion;
                        $cliente->provincia = $provincia;
                        $cliente->CustomerCode = $codigoVendedor;
                        $cliente->CustomerDescription = $vendedorDescripcion;
                        $cliente->codigoBonificacion = $codigoBonificacion;
                        $cliente->bonificacionDescripcion = $bonificacionDescripcion;
                        $cliente->descuento = $this->parseBonificacion($bonificacionDescripcion);
                        $cliente->save(); // Guarda los cambios
    
                        // Incrementar contador de clientes actualizados
                        $clientesActualizados++;
                    } else {
                        // Si no existe, crea un nuevo cliente
                        $cliente = new Cliente();
                        $cliente->cuenta = $cuenta; // Asegúrate de que la propiedad username esté presente
                        $cliente->razonSocial = $razonSocial;
                        $cliente->direccion = $direccion;
                        $cliente->provincia = $provincia;
                        $cliente->CustomerCode = $codigoVendedor;
                        $cliente->CustomerDescription = $vendedorDescripcion;
                        $cliente->codigoBonificacion = $codigoBonificacion;
                        $cliente->bonificacionDescripcion = $bonificacionDescripcion;
                        $cliente->descuento = $this->parseBonificacion($bonificacionDescripcion);

                        $cliente->save(); // Guarda el nuevo cliente
    
                        // Incrementar contador de clientes creados
                        $clientesCreados++;
                    }
                }
            }
    
            return response()->json([
                'message' => 'Carga masiva completada',
                'clientes_creados' => $clientesCreados,
                'clientes_actualizados' => $clientesActualizados
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener productos: ' . $e->getMessage()], 500);
        }
    }

    function parseBonificacion($bonificacionDescripcion) {
        // Verificamos si el valor contiene un operador + o -
        if (preg_match('/^(\d+)([+-])(\d+)$/', $bonificacionDescripcion, $matches)) {
            // Extraemos los números y el operador
            $num1 = (int) $matches[1];
            $operator = $matches[2];
            $num2 = (int) $matches[3];
            
            // Realizamos la operación según el operador encontrado
            return $operator === '+' ? $num1 + $num2 : $num1 - $num2;
        } elseif (is_numeric($bonificacionDescripcion)) {
            // Si solo es un número, lo convertimos a entero
            return (int) $bonificacionDescripcion;
        } else {
            // Si es una palabra u otro valor no numérico, retornamos 0
            return 0;
        }
    }
    
    function tieneProductos(Request $request){
        $categoria = TipoArticulo::where('sub_categoria_id', $request->categoriaId)->where('oculto', 'false')->first();
        

       return $categoria;
        

        


    }


}