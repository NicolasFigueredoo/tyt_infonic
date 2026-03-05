<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Calidad;

class CalidadController extends Controller {
    private $model = Calidad::class;    
    private $name = 'Calidad';
    private $prefixPermission = 'calidad';

    public function all() {
        // sniff($this->prefixPermission . '-*');
        $data = $this->model::orderBy('id', 'asc');
        if ( request()->has('filters') && is_array(request()->filters) ) {
            foreach (request()->filters as $key => $value) {
                $data->where($key, 'like', '%'.$value.'%');
            }
        }
        return $data->paginate();
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
            'descripcion' => 'required',
        ]);
        // store a new item
        if ($id && ! $request->has('__form-input-copy') ) {
            $item = $this->model::find($id);
        } else {
            $item = new $this->model;
        }
        $item->descripcion = $request->descripcion;
        $item->tituloDescripcion = $request->tituloDescripcion;        
        $item->descripcionCertificado = $request->descripcionCertificado;
        $item->descripcionCertificadoDos = $request->descripcionCertificadoDos;        
        if ($request->hasFile('imagenSrc')) {
            $item->imagen = $request->file('imagenSrc')->store('public/calidad');
        }
        if ($request->hasFile('certificadoSrc')) {
            $item->certificado = $request->file('certificadoSrc')->store('public/calidad');
        }
        if ($request->hasFile('certificadoDosSrc')) {
            $item->certificadoDos = $request->file('certificadoDosSrc')->store('public/calidad');
        }
        if ($request->hasFile('logoSrc')) {
            $item->logo = $request->file('logoSrc')->store('public/calidad');
        }
        if ($request->hasFile('logoDosSrc')) {
            $item->logoDos = $request->file('logoDosSrc')->store('public/calidad');
        }
        $item->save();

        return $item;
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
                $keys = ['descripcion'];
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
}