<?php



namespace App\Http\Controllers\Admin;



use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;

use Illuminate\Validation\Rule;

use App\Http\Controllers\Soap\Login;

use App\Http\Controllers\Soap\Products;

use App\Jobs\UpdateArticulo;

use App\Models\Articulo;

use App\Models\ArticulosImagen;

use App\Models\ArticulosColores;

use App\Models\TipoArticulo;

use GuzzleHttp\Client;

use GuzzleHttp\RequestOptions;

use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Str;



class ArticuloController extends Controller {

    private $model = Articulo::class;

    private $name = 'Articulo';

    private $prefixPermission = 'articulo';



    public function all() {        

        $data = $this->model::query();



// Aplicar la ordenación para poner los registros con 'orden' vacío o nulo al final

$data->orderByRaw("CASE WHEN orden IS NULL OR orden = '' THEN 1 ELSE 0 END, orden ASC");



// Aplicar los filtros si existen

if (request()->has('filters') && is_array(request()->filters)) {

    foreach (request()->filters as $key => $value) {

        if ($key == 'oculto' && $value != '') {

            $data->where('oculto', '=', $value);

        } else {

            $data->where($key, 'like', '%' . $value . '%');

        }

    }

}



$results = $data->paginate(30);





        $results->getCollection()->transform(function ($item) {

            return $item->makeHidden(['pathFicha','pathGaleria','pathColores','obtenerGaleria','obtenerColores']);

        });

        return $results;

    }

    public function update()

    {

        UpdateArticulo::dispatch();

        return response()->json(['message' => $this->name . ' Actualizacion en progreso'], 200);

    }

    public function test()

    {        

        return response()->json(['message' => $this->name . ' Actualizacion en progreso'], 200);

    }

    

    



  public function prueba()
    {
        $client           = new Client();
        $apiUrlBase       = 'https://tytsaapi.ddns.net:8443/productos?maxCount=100&page=';
        $totalPages       = 8;
        $productosCreados     = 0;
        $productosActualizados= 0;
        $codigosApi           = []; // para almacenar todos los códigos que devuelve la API

        try {
            // 1) Recorrer todas las páginas de la API
            for ($page = 0; $page <= $totalPages; $page++) {
                $apiUrl   = $apiUrlBase . $page;
                $response = $client->request('GET', $apiUrl, [
                    'headers' => [
                        'X-Api-Key' => 'AQEBEQtz8rVkLVvBKgmYuUmALBpS5GaLG28OUFpd3O08GlfjWrjH3wWt5Hk0GEra5MsMseWHtdise8FGiu3P7iNjEocjzW2T+IJ7c9TH0rbf17trDAc8qK4mAgvv3AMcu5CjuDwzR+9qS1uF5ZZwUNN/FFgD8HRRgkik86XZfttYSPK68RpnFSBrT2XDUTeXvcOdjTjzH7AwJDHj+o9WwskXIQT7Ubgj+oAaTjd4Obq+uyObg75n033Ct5ZO53JTHsvCDfbcMU1BtRtw4CvFynEPiEQ7rufWnDThqJQKqfLvSgBjr2c3L3QV8EKvuNsnNO9vQGrZbuY58sMTXGmMio1iTUxwrnOPpsCO9L4Jr1Onwgu+bIStiJcS2w/3hbzVWR2yo1YWvW0LjJquBNx1I46aUCiw82jHAffI788rrNNuYA8='
                    ],
                    'verify' => false,
                ]);

                $productos = json_decode($response->getBody(), true);

                foreach ($productos['values'] as $value) {
                    // 1.1) Guardar el código en el array de la API
                    $codigosApi[] = $value['codigoProducto'];

                    // 1.2) Buscar si existe el artículo
                    $articulo = Articulo::where('code', $value['codigoProducto'])->first();

                    // — Normalizar y guardar categoría principal —
                    if (!empty($value['unidadNegocio'])) {
                        $unidadNegocio = mb_strtolower($value['unidadNegocio'], 'UTF-8');
                        $unidadNegocio = str_replace(
                            ['á','é','í','ó','ú','ñ'],
                            ['a','e','i','o','u','n'],
                            $unidadNegocio
                        );
                        $categoria = TipoArticulo::whereRaw('LOWER(name)=?', [$unidadNegocio])->first();
                        if (! $categoria) {
                            $categoria = TipoArticulo::create([
                                'name'      => strtoupper($value['unidadNegocio']),
                                'principal' => 'true',
                            ]);
                        } else {
                            $categoria->update([
                                'name'      => strtoupper($value['unidadNegocio']),
                                'principal' => 'true',
                            ]);
                        }
                    }

                    // — Normalizar y guardar subcategoría —
                    if (!empty($value['familiaWeb'])) {
                        $familiaWeb = mb_strtolower($value['familiaWeb'], 'UTF-8');
                        $familiaWeb = str_replace(
                            ['á','é','í','ó','ú','ñ'],
                            ['a','e','i','o','u','n'],
                            $familiaWeb
                        );
                        $subCategoria = TipoArticulo::whereRaw('LOWER(name)=?', [$familiaWeb])->first();
                        $subData = [
                            'name'             => strtoupper($value['familiaWeb']),
                            'sub_categoria_id' => $categoria->id ?? null,
                        ];
                        if (! $subCategoria) {
                            $subCategoria = TipoArticulo::create($subData);
                        } else {
                            $subCategoria->update($subData);
                        }
                    }

                    // 2) Crear o actualizar Artículo
                    $dataArticulo = [
                        'codigoAnterior'   => $value['codigoAnterior'],
                        'tipoProducto'     => $value['tipoProducto'],
                        'name'             => $value['productoDescripcion'],
                        'precioVigente'    => $value['precioVigente'],
                        'stock-disponible' => $value['disponible'],
                        'bultoMinorista'   => $value['bultoMinorista'],
                        'bultoMayorista'   => $value['bultoMayorista'],
                        'sub_categoria'    => $subCategoria->id ?? null,
                        'marca'            => $value['marca'],
                    ];

                    if (! $articulo) {
                        $articulo = Articulo::create(array_merge(
                            ['code' => $value['codigoProducto']],
                            $dataArticulo
                        ));
                        $productosCreados++;
                    } else {
                        $articulo->update($dataArticulo);
                        $productosActualizados++;
                    }

                    // 3) Sincronizar pivote de categorías
                    if (isset($subCategoria)) {
                        $articulo->categorias()->syncWithoutDetaching($subCategoria->id);
                    }
                }
            }

            // 4) Eliminar artículos que ya no están en la API
            $aEliminar = Articulo::whereNotIn('code', $codigosApi)->get();
            $productosEliminados = $aEliminar->count();
            foreach ($aEliminar as $art) {
                $art->categorias()->detach();
                $art->delete();
            }

            // 5) Responder con todos los conteos
            return response()->json([
                'message'               => 'Carga masiva completada',
                'productos creados'     => $productosCreados,
                'productos actualizados'=> $productosActualizados,
                'productos eliminados'  => $productosEliminados,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al obtener productos: ' . $e->getMessage()
            ], 500);
        }
    }































    public function find($id) {



        if($id == 'update'){

            $this->updateApi();

            return response()->json(['message' => ' Actualizacion en progreso'], 200);

        }else{

            $item = $this->model::find($id);

            if ($item) {            

               return $item;

            }

        }

        return response()->json(['message' => $this->name . ' not found'], 404);

    }   



    public function buscarProductos(Request $request)

{

    $term = $request->input('term'); // El término de búsqueda



    // Buscar productos que coincidan con el término en name, code o description

$productos = Articulo::where(function ($query) use ($term) {

        $query->where('name', 'LIKE', '%' . $term . '%')

            ->orWhere('code', 'LIKE', '%' . $term . '%')

            ->orWhere('codigoAnterior', 'LIKE', '%' . $term . '%')

            ->orWhere('description', 'LIKE', '%' . $term . '%');

    })

    ->where('oculto', 'false') // Filtro para productos no ocultos

    ->whereNotNull('sub_categoria')

    ->get(['id', 'name', 'code', 'description', 'oculto']);

 // Selecciona solo los campos necesarios



    // Devolver los productos en formato JSON

    return response()->json($productos);

}



    public function storeColor(Request $request, $id = null) {

        return "ok";

        $item = $this->model::find($id);

        $color = ArticulosColores::where('productId','=',$id)->where('color1','=',$request->color1)->where('color2','=',$request->color2)->first();

        if($color){

            return $item;

        }

        $color = new ArticulosColores;

        $color->color1 = $request->color1;

        $color->color2 = $request->color2;

        $color->productId = $item->id;

        $color->save();

        return $item;

    }

    public function store(Request $request, $id = null) {





        // colocar en mayusculas el code y name

        $request->code = strtoupper($request->code);

        $request->name = strtoupper($request->name);

        // validate the request

        $request->validate([

            // debe ser unico en la tabla, excepto si se esta editando que puede ser el mismo

            // 'code' => ['required', 'string', 'max:255', Rule::unique('articulos')->ignore($id)],

            'name' => 'required|string|max:255|min:3',

            // 'description' => 'required|string|max:255',            

        ]);

        // store a new item

        if ($id && ! $request->has('__form-input-copy') ) {

            $item = $this->model::find($id);

        } else {

            $item = new $this->model;

        }

        $item->code = $request->code;

        $item->name = $request->name;

        $item->nameEnglish = $request->nameEnglish;


        if ($request->filled('slug')) {
            $item->slug = Str::slug($request->slug);
        } else {
            $baseSlug = Str::slug($request->name);
            $slugExists = $this->model::where('slug', $baseSlug)
                ->where('id', '!=', $item->id ?? 0)
                ->exists();
            $item->slug = $slugExists
                ? $baseSlug . '-' . Str::slug($request->code)
                : $baseSlug;
        }
        

        $item->cantidad = $request->cantidad;

        $item->minimo = $request->minimo;

        $item->precioVigente = $request->precioVigente;

        $item->codigoAnterior = $request->codigoAnterior;

        $item->tipoProducto = $request->tipoProducto;

        $item->description = $request->description;

        $item->descriptionPrivada = $request->descriptionPrivada;

        $item->oculto = $request->oculto;

        $item->orden = $request->orden;

        $item->marca = $request->marca;

        $item->destacado = $request->destacado;

        $item->bultoMinorista = $request->bultoMinorista;

        $item->bultoMayorista = $request->bultoMayorista;

        $item->video = $request->video;

        $item->videoTwo = $request->videoTwo;



        $item->{'stock-min'} = $request->{'stock-min'};        

        if ($request->hasFile('imagenSrc')) {

            // Elimina la imagen existente

            File::delete(public_path('inicio/' . $item->imagen));

        

            // Guarda la imagen principal

            $file = $request->file('imagenSrc');

            $nombreImagen = 'media_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $file->move('storage/inicio/', $nombreImagen);

            $item->imagen = 'inicio/' . $nombreImagen;

        }

        

        $arrayimg = array();

        

        // Procesa las imágenes de la galería con enlaces existentes

        if ($request->galeriaLink) {

            $galeriaLinks = $request->galeriaLink;

            foreach ($galeriaLinks as $foto) {

                $pathGaleria = explode('storage', $foto);

                $galeriaPath = 'public' . $pathGaleria[1];

                array_push($arrayimg, $galeriaPath);

            }

        }

        

        // Procesa y guarda las nuevas imágenes de la galería

        if ($request->hasFile('galeria')) {

            $fotosGaleria = $request->file('galeria');

            foreach ($fotosGaleria as $foto) {

                $nombreFoto = 'media_' . uniqid() . '.' . $foto->getClientOriginalExtension();

                $foto->move('storage/inicio/', $nombreFoto);

                $rutaGaleria = 'inicio/' . $nombreFoto;

                array_push($arrayimg, $rutaGaleria);

            }

        }

        

        // Almacena las rutas de la galería en el formato requerido

        $item->galeria = implode(',', $arrayimg);

        

        

        $item->save();

        $color = ArticulosColores::where('productId','=',$item->id)->forceDelete();            

        foreach($request->colores as $color){

            $colorAux = json_decode($color);

            $color = new ArticulosColores;

            $color->color1 = $colorAux->color1;

            $color->color2 = $colorAux->color2;

            $color->productId = $item->id;

            $color->save();            

        }

        return $color;

    }   



    public function delete($id) {

        $item = $this->model::find($id);

        if ($item) {

            $item->delete();

            return $item;

        }

        abort(500, 'El registro que intenta eliminar no existe');

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



    public function deleteImg($id,$index) {

        $productos = Articulo::find($id);

        $explode = explode(',', $productos->galeria);

        unset($explode[$index]);

        $productos->galeria = implode(',', $explode);

        $productos->save();

        return response()->json(['message' => 'Imagen eliminada'], 202);

    }



    public function deleteColor($id) {

        $item = ArticulosColores::find($id);

        if ($item) {

            $item->delete();

            return $item;

        }

        return "Ok";

    }



    public function restore($id) {

        $item = $this->model::withTrashed()->find($id);

        if ($item) {

            $item->restore();

            return $item;

        }

        abort(500, 'El registro que intenta restaurar no existe');

    }



    public function destroy($id) {

        $item = $this->model::withTrashed()->find($id);

        $item->forceDelete();

        return $item;

    }

    public function listSelect(Request $request) {

        $data = $this->model::orderBy('orden', 'asc');

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

        return $data->get();

    }



    public function guardarCantidadEnSesion(Request $request) {

        $cantidad = $request->input('cantidad');

        session(['cantidad' => $cantidad]);

        return response()->json(['success' => true]);

    }

}