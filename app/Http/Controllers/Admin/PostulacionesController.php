<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PostulacionesController extends Controller
{
    // POST /adm/postulaciones/
    public function all(Request $request)
    {
        $query = DB::table('postulaciones')
            ->leftJoin('ofertas_laborales', 'postulaciones.oferta_id', '=', 'ofertas_laborales.id')
            ->select(
                'postulaciones.*',
                'ofertas_laborales.titulo as oferta_titulo'
            )
            ->orderByDesc('postulaciones.id');

        if ($request->has('filters') && is_array($request->filters)) {
            foreach ($request->filters as $key => $value) {
                if ($value) $query->where('postulaciones.' . $key, 'like', '%' . $value . '%');
            }
        }

        $items = $query->paginate($request->input('per_page', 20));
        return response()->json($items);
    }

    // GET /adm/postulaciones/{id}
    public function find($id)
    {
        $item = DB::table('postulaciones')
            ->leftJoin('ofertas_laborales', 'postulaciones.oferta_id', '=', 'ofertas_laborales.id')
            ->select('postulaciones.*', 'ofertas_laborales.titulo as oferta_titulo')
            ->where('postulaciones.id', $id)
            ->first();

        if (!$item) return response()->json(['message' => 'No encontrado'], 404);
        return response()->json($item);
    }

    // GET /adm/postulaciones/delete/{id}
    public function delete($id)
    {
        DB::table('postulaciones')->where('id', $id)->delete();
        return response()->json(['ok' => true]);
    }
}