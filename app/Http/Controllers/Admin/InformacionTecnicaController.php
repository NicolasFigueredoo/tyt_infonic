<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\InformacionTecnica;

class InformacionTecnicaController extends Controller {
    private $model = InformacionTecnica::class;
    private $name = 'Informacion Tecnica';    

    public function all() {
        // sniff($this->prefixPermission . '-*');
        $data = $this->model::orderBy('id', 'desc');
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
        $item = $this->model::find($id);
        if ($item) {
            // $item->permissions = $item->permissions()->pluck('id');
            return $item;
        }
        return response()->json(['message' => $this->name . ' not found'], 404);
    }

    public function store(Request $request, $id = null) {        
        $request->orden = strtoupper($request->orden);
        // validate the request
        $request->validate([
            // debe ser unico en la tabla, excepto si se esta editando que puede ser el mismo            
            'name' => 'required|string|max:255|min:3',
            // 'description' => 'required|string|max:255',            
        ]);
        // store a new item
        if ($id && ! $request->has('__form-input-copy') ) {
            $item = $this->model::find($id);
        } else {
            $item = new $this->model;
        }                
        $item->description = $request->description;
        
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
        $data = $this->model::orderBy('id', 'desc');
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

}