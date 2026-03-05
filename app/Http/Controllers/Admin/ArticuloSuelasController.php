<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\ArticuloSuela;

class ArticuloSuelasController extends Controller {
    private $model = ArticuloSuela::class;
    private $name = 'Articulo Suelas';
    private $prefixPermission = 'articulo_suelas';

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
        // colocar en mayusculas el code y name
        $request->code = strtoupper($request->code);
        $request->name = strtoupper($request->name);
        // validate the request
        $request->validate([
            // debe ser unico en la tabla, excepto si se esta editando que puede ser el mismo
            'code' => ['required', 'string', 'max:255', Rule::unique('articulo_suelas')->ignore($id)],
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
        $item->description = $request->description;
        $item->talle = $request->talle;
        $item->{'stock-min'} = $request->{'stock-min'};        
        if ($request->hasFile('imagenSrc')) {
            $item->imagen = $request->file('imagenSrc')->store('public/articulosSuelas');
        }
        if ($request->hasFile('fichaHref')) {
            
            $item->archivo = $request->file('fichaHref')->store('public/articulosSuelas');
        }
        $arrayimg = array(); 
        
        if($request->galeriaLink){
            $galeria = $request->galeriaLink;
            foreach($galeria as $foto){
                $galeria = $foto;
                $galeria = explode('storage',$galeria);
                $galeria = 'public'.$galeria[1];                
                array_push($arrayimg, $galeria);
            }                
        }

        if ($request->hasFile('galeria')) {
            $fotos = $request->file('galeria');
            foreach($fotos as $foto){
                $galeria = $foto->store('public/articulosSuelas');
                array_push($arrayimg, $galeria);
            }
        }        
        $item->galeria = implode(',', $arrayimg);

        $arrayColores = array(); 

        if($request->coloresLink){
            $colores = $request->coloresLink;
            foreach($colores as $foto){
                $colores = $foto;
                $colores = explode('storage',$colores);
                $colores = 'public'.$colores[1];                
                array_push($arrayColores, $colores);
            }                
        }

        if ($request->hasFile('color')) {
            $fotos = $request->file('color');            
            foreach($fotos as $foto){
                $colores = $foto->store('public/articulosSuelas');
                array_push($arrayColores, $colores);
            }            
        }
        $item->colores = implode(',', $arrayColores);
        
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
    public function deleteImg($img){
        $productos = $this->model::where('galeria','LIKE','%'.$img.'%');
        $explode = explode(',', $productos->galeria);
        $img = str_replace('-','/',$img);
        $img = $img.".png";
        $key = array_search($img, $explode);
        if($key){
            unset($explode[$key]);
        }
        $productos->galeria = implode(',', $explode);
        $productos->save();
        return $productos;
    }
}