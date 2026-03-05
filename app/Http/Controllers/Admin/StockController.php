<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Almacen;
use App\Models\Articulo;
use App\Models\TipoArticulo;
use App\Models\ArticuloStock;
use App\Models\ArticuloLog;

class StockController extends Controller {

    public function addPosition(Request $request, $id = null) {
        // validate the request
        $request->validate([
            'articulo_id'   => 'required|integer',
            'almacen_id'    => 'required|integer',
            'ubicacion'     => 'required|string|max:255',
            'cantidad'      => 'required|numeric',
            'peso'          => 'required|numeric',
            'observaciones' => 'nullable|string|max:255',
        ]);
        ArticuloStock::create([
            'articulo_id'   => $request->articulo_id,
            'almacen_id'    => $request->almacen_id,
            'ubicacion'     => $request->ubicacion,
            'cantidad'      => $request->cantidad,
            'peso'          => $request->peso,
            'observaciones' => $request->observaciones,
        ]);
        ArticuloLog::create([
            'articulo_id' => $request->articulo_id,
            'user_id'     => auth()->user()->id,
            'message'     => 'Se ha añadido en el almacen ' . Almacen::find($request->almacen_id)->name . ' la ubicacion ' . $request->ubicacion . ' con una cantidad de ' . $request->cantidad . ' y un peso de ' . $request->peso . ' kg',
        ]);

        return response()->json(['message' => 'Position added'], 200);
    }

    public function findArticulo($id) {
        $articulo = Articulo::with(['tipo', 'stock', 'stock.almacen', 'logs', 'logs.user'])->find($id);
        if ($articulo) {
            return $articulo;
        }
        return response()->json(['message' => 'Articulo not found'], 404);
    }

    public function allArticulo() {
        $data = Articulo::with(['tipo', 'stock'])->orderBy('id', 'desc');
        if ( request()->has('filters') && is_array(request()->filters) ) {
            foreach (request()->filters as $key => $value) {
                $data->where($key, 'like', '%'.$value.'%');
            }
        }
        if ( request()->has('trash') && request()->trash == 1 ) {
            $data->onlyTrashed();
        }
        $data = $data->paginate(20);
        // append attribute stock_real_total
        $data->each(function ($item, $key) {
            $item->append('stock_cantidad_total');
            $item->append('stock_peso_total');
        });

        return $data;
    }

}