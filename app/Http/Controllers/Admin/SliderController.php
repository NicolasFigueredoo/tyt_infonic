<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Slider;


class SliderController extends Controller {
    private $model = Slider::class;
    private $name = 'Slider';
    private $prefixPermission = 'empresa';

    public function all() {        
        $data = $this->model::orderBy('id', 'asc');        
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
            'descripcion' => 'required|string|max:255',
        ]);
        // store a new item
        if ($id && ! $request->has('__form-input-copy') ) {
            $item = $this->model::find($id);
        } else {
            $item = new $this->model;
        }
        $item->descripcion = $request->descripcion;
        $item->titulo = $request->titulo;
        $item->orden = $request->orden;
        if ($request->hasFile('imagenSrc')) {
            $item->imagen = $request->file('imagenSrc')->store('public/inicio');
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