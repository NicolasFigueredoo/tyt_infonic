<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ArchivosMediaController extends Controller
{
    // POST /adm/archivosmedia/
public function all(Request $request)
{
    $query = DB::table('archivos_media')->orderByDesc('id');

    if ($request->has('filters') && is_array($request->filters)) {
        foreach ($request->filters as $key => $value) {
            if ($value) $query->where($key, 'like', '%' . $value . '%');
        }
    }

    $items = $query->paginate($request->input('per_page', 20));
    foreach ($items as $item) {
        $item->url_publica = url('storage/' . $item->path);
    }
    return response()->json($items);
}

    // GET /adm/archivosmedia/{id}
    public function find($id)
    {
        $item = DB::table('archivos_media')->where('id', $id)->first();
        if (!$item) return response()->json(['message' => 'No encontrado'], 404);

        $item->url_publica = url('storage/' . $item->path);
        return response()->json($item);
    }

    // POST /adm/archivosmedia/store/{id?}
    public function store(Request $request, $id = null)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo'   => 'required|in:imagen,video,pdf,otro',
        ]);

        $data = [
            'nombre'     => $request->nombre,
            'tipo'       => $request->tipo,
            'activo'     => $request->boolean('activo', true) ? 1 : 0,
            'updated_at' => now(),
        ];

        if ($request->hasFile('archivo')) {
            $archivo   = $request->file('archivo');
            $extension = $archivo->getClientOriginalExtension();
            $size      = $archivo->getSize();

            // Si es edición, borrar archivo viejo
            if ($id) {
                $viejo = DB::table('archivos_media')->where('id', $id)->value('path');
                if ($viejo) Storage::disk('public')->delete($viejo);
            }

            $path = $archivo->store('archivos_media', 'public');

            $data['path']      = $path;
            $data['extension'] = $extension;
            $data['size']      = $size;
        }

        if ($id) {
            DB::table('archivos_media')->where('id', $id)->update($data);
            $item = DB::table('archivos_media')->where('id', $id)->first();
        } else {
            if (!$request->hasFile('archivo')) {
                return response()->json(['errors' => ['archivo' => ['El archivo es requerido']]], 422);
            }
            $data['created_at'] = now();
            $newId = DB::table('archivos_media')->insertGetId($data);
            $item  = DB::table('archivos_media')->where('id', $newId)->first();
        }

        $item->url_publica = url('storage/' . $item->path);
        return response()->json($item);
    }

    // GET /adm/archivosmedia/delete/{id}
    public function delete($id)
    {
        $item = DB::table('archivos_media')->where('id', $id)->first();
        if ($item && $item->path) {
            Storage::disk('public')->delete($item->path);
        }
        DB::table('archivos_media')->where('id', $id)->delete();
        return response()->json(['ok' => true]);
    }
}
