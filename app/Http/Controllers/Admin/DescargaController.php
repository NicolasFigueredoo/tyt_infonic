<?php



namespace App\Http\Controllers\Admin;



use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;

use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\File;



use App\Models\Descarga;



class DescargaController extends Controller {





    protected $model = Descarga::class;

    protected $name = 'Lista de precios';

    // Discrimina la seccion: 'lista' (Lista de precios) o 'catalogo' (Catalogos).
    protected $tipo = 'lista';



    public function all() {

        $data = $this->model::where('tipo', $this->tipo)->orderBy('orden', 'asc');

        if ( request()->has('filters') && is_array(request()->filters) ) {

            foreach (request()->filters as $key => $value) {

                $data->where($key, 'like', '%'.$value.'%');

            }

        }

        if ( request()->has('trash') && request()->trash == 1 ) {

            $data->onlyTrashed();

        }

        return $data->paginate(20);

    }



    public function find($id) {

        $item = $this->model::where('tipo', $this->tipo)->find($id);

        if ($item) {

            // $item->permissions = $item->permissions()->pluck('id');

            return $item;

        }

        return response()->json(['message' => $this->name . ' not found'], 404);

    }



    public function store(Request $request, $id = null)

    {

        // validate the request



        $request->validate([            

            'orden'         => 'required|string|max:255',

            'titulo'         => 'required|string|max:255',

            'tituloEnglish'         => 'required|string|max:255'



        ]);

        // store a new item

        if ($id && !$request->has('__form-input-copy')) {

            $item = $this->model::withTrashed()->find($id);

        } else {

            $item = new $this->model;

        }

        $item->titulo = $request->titulo;

        $item->tituloEnglish = $request->tituloEnglish;

        $item->orden = $request->orden;

        $item->link = $request->link;
        $item->tipo = $this->tipo;



        if ($request->hasFile('imagen')){

            File::delete(public_path('inicio/'.$item->imagen));



            $file = $request->file('imagen');

            $nombreImagen = 'media_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $file->move('storage/inicio/', $nombreImagen);

            $item->imagen  = 'inicio/' . $nombreImagen;



        }



        $item->save();



        return $item;

    }





    public function delete($id) {

        $item = $this->model::where('tipo', $this->tipo)->find($id);

        if ($item) {

            $item->delete();

            return $item;

        }

        abort(500, 'El registro que intenta eliminar no existe');

    }





}