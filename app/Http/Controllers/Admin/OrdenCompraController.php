<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrdenCompra;
use App\Models\OrdenCompraItems;

class OrdenCompraController extends Controller {
    private $model = OrdenCompra::class;
    private $name = 'OrdenCompra';
    private $prefixPermission = 'orden_compra';

    public function all() {
        // sniff($this->prefixPermission . '-*');
        $data = $this->model::with(['proveedor', 'items', 'tipo'])->orderBy('id', 'desc');
        if ( request()->has('filters') && is_array(request()->filters) ) {
            foreach (request()->filters as $key => $value) {
                $data->where($key, 'like', '%'.$value.'%');
            }
        }
        return $data->paginate();
    }

    public function find($id) {
        $item = $this->model::with(['proveedor', 'items', 'tipo', 'items.articulo'])->find($id);
        if ($item) {
            // $item->permissions = $item->permissions()->pluck('id');
            return $item;
        }
        return response()->json(['message' => $this->name . ' not found'], 404);
    }

    public function store(Request $request, $id = null) {
        // validate the request
        $request->validate([
            'proveedor_id' => 'required|integer',
            'orden_compra_tipo_id' => 'required|integer',
            'fecha_emision' => 'required|date',
            'nro_orden' => 'required|string|max:255',
            'fecha_entrega' => 'required|date',
            'nro_confirmacion' => 'required|string|max:255',
        ]);
        // store a new item
        if ($id && ! $request->has('__form-input-copy') ) {
            $item = $this->model::find($id);
        } else {
            $item = new $this->model;
        }

        $item->proveedor_id         = $request->proveedor_id;
        $item->orden_compra_tipo_id = $request->orden_compra_tipo_id;
        $item->fecha_emision        = $request->fecha_emision;
        $item->nro_orden            = $request->nro_orden;
        $item->fecha_entrega        = $request->fecha_entrega;
        $item->nro_confirmacion     = $request->nro_confirmacion;
        $item->save();
        if ( request()->has('items') ) {
            foreach (request()->items as $key => $ii) {
                OrdenCompraItems::create([
                    'articulo_id'     => $ii['articulo_id'],
                    'cantidad'        => $ii['cantidad'],
                    'tamano_y'        => $ii['ancho'],
                    'tamano_x'        => $ii['largo'],
                    'precio_unitario' => $ii['precio_unitario'],
                    'orden_compra_id' => $item->id,
                ]);
            }
        }
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
        $data = $this->model::orderBy('id', 'desc');
        if ( request()->has('search') && strlen(request()->search) ) {
            $data->where(function($query) {
                $keys = ['name'];
                foreach ($keys as $key => $colName) {
                    $query->orWhere($colName, 'like', '%'.request()->search.'%');
                }
            });
        }
        return $data->get();
    }
}