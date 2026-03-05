<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Inicio;
use App\Models\Logo;
use App\Models\Slider;
use Illuminate\Support\Facades\File;

class InicioController extends Controller {
    private $model = Inicio::class;
    private $modelSilder = Slider::class;
    private $modelLogo = Logo::class;
    private $name = 'Inicio';
    private $prefixPermission = 'inicio';

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
        $item->tituloVideo = $request->tituloVideo;
        $item->descripcionVideo = $request->descripcionVideo;
        $item->descripcion = $request->descripcion;
        $item->titulo = $request->titulo;
        $item->descripcionDos = $request->descripcionDos;
        $item->tituloDos = $request->tituloDos;
        $item->quieroCliente = $request->quieroCliente;

        $item->descripcionEnglish = $request->descripcionEnglish;
        $item->tituloEnglish = $request->tituloEnglish;
        $item->descripcionDosEnglish = $request->descripcionDosEnglish;
        $item->tituloDosEnglish = $request->tituloDosEnglish;

        $item->botonPrincipal = $request->botonPrincipal;
        $item->botonPrincipalEnglish = $request->botonPrincipalEnglish;
        $item->botonPrincipalLink = $request->botonPrincipalLink;

        $item->botonSecundario = $request->botonSecundario;
        $item->botonSecundarioEnglish = $request->botonSecundarioEnglish;
        $item->botonSecundarioLink = $request->botonSecundarioLink;

        
        $item->botonPrincipalDos = $request->botonPrincipalDos;
        $item->botonPrincipalDosEnglish = $request->botonPrincipalDosEnglish;
        $item->botonPrincipalDosLink = $request->botonPrincipalDosLink;





        if ($request->hasFile('videoSrc')) {
            $item->video = $request->file('videoSrc')->store('public/inicio');
        }

        if ($request->hasFile('imagenSrc')){
            File::delete(public_path('inicio/'.$item->image));

            $file = $request->file('imagenSrc');
            $nombreImagen = 'media_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('storage/inicio/', $nombreImagen);
            $item->imagen  = 'inicio/' . $nombreImagen;

        }

        if ($request->hasFile('imagenFooter')){
            File::delete(public_path('inicio/'.$item->image));

            $file = $request->file('imagenFooter');
            $nombreImagen = 'media_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('storage/inicio/', $nombreImagen);
            $item->imagenFooter  = 'inicio/' . $nombreImagen;

        }
        
        if ($request->hasFile('imagenSrcDos')){
            File::delete(public_path('inicio/'.$item->image));

            $file = $request->file('imagenSrcDos');
            $nombreImagen = 'media_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('storage/inicio/', $nombreImagen);
            $item->imagenDos  = 'inicio/' . $nombreImagen;

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
        $data = $this->modelSilder::where('seccion','bannerPrincipal')->orderBy('orden');        
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

        if ($id && ! $request->has('__form-input-copy') ) {
            $item = $this->modelSilder::find($id);
        } else {
            $item = new $this->modelSilder;
        }
        $item->descripcion = $request->descripcion;
        $item->orden = $request->orden;
        $item->titulo = $request->titulo;
        $item->seccion = 'bannerPrincipal';
        $item->tituloEnglish = $request->tituloEnglish;
        $item->descripcionEnglish = $request->descripcionEnglish;



        if ($request->hasFile('imagenSrc')) {
            File::delete(public_path('empresa/' . $item->image));
            $file = $request->file('imagenSrc');
            $nombreImagen = 'media_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('storage/empresa/', $nombreImagen);
            $item->imagen = 'empresa/' . $nombreImagen;
                    $extension = strtolower($file->getClientOriginalExtension());
            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                $item->tipo = 'imagen';
            } elseif (in_array($extension, ['mp4', 'avi', 'mov', 'wmv'])) {
                $item->tipo = 'video';
            } else {
                $item->tipo = 'otro'; 
            }
        }

            
      

        $item->tipo = 
        
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
    ///LOGOS
    public function allLogos() {        
        $data = $this->modelLogo::orderBy('id', 'asc');        
        return $data->paginate();
    }

    public function findLogos($id) { 
        
        $item = $this->modelLogo::find($id);
        
        if ($item) {
            // $item->permissions = $item->permissions()->pluck('id');        
            return $item;
        }
        
        return response()->json(['message' => $this->name . ' not found'], 404);
    }

    public function storeLogos(Request $request, $id = null) {
        
        // store a new item
        if ($id && ! $request->has('__form-input-copy') ) {
            $item = $this->modelLogo::find($id);
        } else {
            $item = new $this->modelLogo;
        }

        if ($request->hasFile('image')){
            File::delete(public_path('inicio/'.$item->image));

            $file = $request->file('image');
            $nombreImagen = 'media_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('storage/inicio/', $nombreImagen);
            $item->image  = 'inicio/' . $nombreImagen;

        }
     
        $item->save();

        return $item;
    }

    public function deleteLogos($id) {
        $item = $this->modelLogo::find($id);
        $item->delete();
        return $item;
    }

    public function restoreLogos($id) {
        $item = $this->modelLogo::withTrashed()->find($id);
        $item->restore();
        return $item;
    }

    public function destroyLogos($id) {
        $item = $this->modelLogo::withTrashed()->find($id);
        $item->forceDelete();
        return $item;
    }

    public function changeIdioma(Request $request){
        session(['locale' => $request->idioma]);

        return redirect()->back();
    }

}