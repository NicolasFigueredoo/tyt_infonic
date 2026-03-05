<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Empresa;
use App\Models\Slider;
use Illuminate\Support\Facades\File;

class EmpresaController extends Controller {
    private $model = Empresa::class;
    private $modelSilder = Slider::class;
    private $name = 'Empresa';
    private $prefixPermission = 'empresa';

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
        $item->video = $request->video;
        $item->descripcion_logo = $request->descripcionLogo;
        $item->descripcion_logo_dos = $request->descripcionLogoDos;
        $item->descripcion_logo_tres = $request->descripcionLogoTres;
        $item->titulo = $request->titulo;
        $item->titulo_dos = $request->tituloDos;
        $item->titulo_tres = $request->tituloTres;

        

        $item->descripcionEnglish = $request->descripcionEnglish;
        $item->tituloEnglish = $request->tituloEnglish;

        if ($request->hasFile('imagenNavbar')){
            File::delete(public_path('inicio/'.$item->fondoNavbar));

            $file = $request->file('imagenNavbar');
            $nombreImagen = 'media_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('storage/inicio/', $nombreImagen);
            $item->fondoNavbar  = 'inicio/' . $nombreImagen;

        }

        if ($request->hasFile('imagenSrc')){
            File::delete(public_path('inicio/'.$item->image));

            $file = $request->file('imagenSrc');
            $nombreImagen = 'media_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('storage/inicio/', $nombreImagen);
            $item->imagen  = 'inicio/' . $nombreImagen;

        }
        if ($request->hasFile('logoSrc')) {
            $item->logo = $request->file('logoSrc')->store('public/empresa');
        }
        if ($request->hasFile('logoDosSrc')) {
            $item->logo_dos = $request->file('logoDosSrc')->store('public/empresa');
        }
        if ($request->hasFile('logoTresSrc')) {
            $item->logo_tres = $request->file('logoTresSrc')->store('public/empresa');
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
    ///SLIDER
    public function allSlider() {        
        $data = $this->modelSilder::where('seccion','empresa')->orderBy('id', 'asc');        
        return $data->paginate();
    }

    public function findSlider($id) { 
        
        $item = $this->modelSilder::find($id);
        if ($item) {
            // $item->permissions = $item->permissions()->pluck('id');        
            return $item;
        }
        return response()->json(['message' => $this->name . ' not found'], 404);
    }

    public function storeSlider(Request $request, $id = null) {
        // validate the request
        $request->validate([
            'descripcion' => 'required|string|max:255',
        ]);
        // store a new item
        if ($id && ! $request->has('__form-input-copy') ) {
            $item = $this->modelSilder::find($id);
        } else {
            $item = new $this->modelSilder;
        }
        $item->orden = $request->orden;        
        $item->titulo = $request->titulo;        
        $item->descripcion = $request->descripcion;        
        $item->tituloEnglish = $request->tituloEnglish;        
        $item->descripcionEnglish = $request->descripcionEnglish;   
        $item->seccion = 'empresa';
        if ($request->hasFile('imagenSrc')) {
            $item->imagen = $request->file('imagenSrc')->store('public/empresa');
        }        
        $item->save();

        return $item;
    }

    public function deleteSlider($id) {
        $item = $this->modelSilder::find($id);
        $item->delete();
        return $item;
    }

    public function restoreSlider($id) {
        $item = $this->modelSilder::withTrashed()->find($id);
        $item->restore();
        return $item;
    }

    public function destroySlider($id) {
        $item = $this->modelSilder::withTrashed()->find($id);
        $item->forceDelete();
        return $item;
    }

}