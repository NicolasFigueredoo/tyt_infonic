<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Rede;
use App\Models\Secciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SeccionesController extends Controller {
    private $model = Secciones::class;
    private $name = 'Seccion';


    public function all() {

        
        $data = $this->model::orderBy('orden', 'asc'); // Cambiado 'id' por 'orden'

        if (request()->has('filters') && is_array(request()->filters)) {
            foreach (request()->filters as $key => $value) {
                $data->where($key, 'like', '%' . $value . '%');
            }
        }
        
        if (request()->has('trash') && request()->trash == 1) {
            $data->onlyTrashed();
        }
        
        return $data->paginate(20);
        

    }

    public function find($id) {
        $item = $this->model::find($id);
        if ($item) {
            // $item->permissions = $item->permissions()->pluck('id');
            return $item;
        }
        return response()->json(['message' => $this->name . ' not found'], 404);
    }

    public function store(Request $request, $id = null) {
    
        // store a new item
        if ($id && ! $request->has('__form-input-copy') ) {
            $item = $this->model::find($id);
        } else {
            $item = new $this->model;
        }        



        if ($request->hasFile('imagen')){
            File::delete(public_path('inicio/'.$item->imagen));

            $file = $request->file('imagen');
            $nombreImagen = 'media_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('storage/inicio/', $nombreImagen);
            $item->imagen  = 'inicio/' . $nombreImagen;

        }
          

        $item->tituloEnglish = $request->tituloEnglish;

        $item->titulo = $request->titulo;
        $item->ruta = $request->ruta;        
        $item->orden = $request->orden;        

        $item->save();

        return $item;        
    }

    
    public function delete($id) {
        $item = $this->model::find($id);
        if ($item) {
            $item->delete();
            return $item;
        }
        abort(500, 'El registro que intenta eliminar no existe');
    }
    
       

 
}