<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class EmpleosController extends Controller
{
    // POST /adm/empleos/
    public function all(Request $request)
    {
        $query = DB::table('ofertas_laborales')->orderByDesc('id');

        if ($request->has('filters') && is_array($request->filters)) {
            foreach ($request->filters as $key => $value) {
                if ($value) $query->where($key, 'like', '%' . $value . '%');
            }
        }

        $items = $query->paginate($request->input('per_page', 20));
        return response()->json($items);
    }

    // GET /adm/empleos/{id}
    public function find($id)
    {
        $item = DB::table('ofertas_laborales')->where('id', $id)->first();
        if (!$item) return response()->json(['message' => 'No encontrado'], 404);
        return response()->json($item);
    }

    // POST /adm/empleos/store/{id?}
    public function store(Request $request, $id = null)
    {
        $request->validate([
            'titulo'             => 'required|string|max:255',
            'descripcion'        => 'nullable|string',
            'requisitos'         => 'nullable|string',
            'ubicacion'          => 'nullable|string|max:255',
            'fecha_publicacion'  => 'nullable|date',
        ]);

        $data = [
            'titulo'            => $request->titulo,
            'descripcion'       => $request->descripcion,
            'requisitos'        => $request->requisitos,
            'ubicacion'         => $request->ubicacion,
            'fecha_publicacion' => $request->fecha_publicacion,
            'activo' => $request->input('activo') == '1' ? 1 : 0,
            'updated_at'        => now(),
        ];

        if ($id) {
            DB::table('ofertas_laborales')->where('id', $id)->update($data);
            $item = DB::table('ofertas_laborales')->where('id', $id)->first();
        } else {
            $data['created_at'] = now();
            $newId = DB::table('ofertas_laborales')->insertGetId($data);
            $item  = DB::table('ofertas_laborales')->where('id', $newId)->first();
        }

        return response()->json($item);
    }

    // GET /adm/empleos/delete/{id}
    public function delete($id)
    {
        DB::table('ofertas_laborales')->where('id', $id)->delete();
        return response()->json(['ok' => true]);
    }
}
