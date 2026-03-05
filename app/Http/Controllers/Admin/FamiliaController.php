<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Familia;
use Illuminate\Support\Facades\Storage;

class FamiliaController extends Controller {
    private $model = Familia::class;
    private $name = 'Familia';
    private $prefixPermission = 'tipo_articulo';

    public function all() {
        // sniff($this->prefixPermission . '-*');
        $data = $this->model::orderBy('orden', 'asc');
        if ( request()->has('filters') && is_array(request()->filters) ) {
            foreach (request()->filters as $key => $value) {
                $data->where($key, 'like', '%'.$value.'%');
            }
        }
        return $data->paginate(100);
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
        $item->orden = $request->orden;
        $item->destacado = $request->destacado;
        if ($request->hasFile('imagenSrc')) {
            $item->imagen = $request->file('imagenSrc')->store('public/tipo-articulo', 'public');
        }    
        if ($request->hasFile('imagenMarca')) {
            $item->imagenMarca = $request->file('imagenMarca')->store('public/tipo-articulo', 'public');
        }         
        $item->oculto = $request->oculto;
        
        $item->save();

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
        
        $subcategorias = TipoArticulo::where('sub_categoria_id', $categoriaId)->where('oculto', 'false')->get();
    
        return view('partials.subcategoria', compact('subcategorias'))->render();
        
    }
    


}