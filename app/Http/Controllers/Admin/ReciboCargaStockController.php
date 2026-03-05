<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrdenCompra;

class ReciboCargaStockController extends Controller {
    public function all() {
        // sniff($this->prefixPermission . '-*');
        $data = OrdenCompra::with(['proveedor', 'items', 'tipo'])->orderBy('id', 'desc');
        if ( request()->has('filters') && is_array(request()->filters) ) {
            foreach (request()->filters as $key => $value) {
                $data->where($key, 'like', '%'.$value.'%');
            }
        }
        $data->where('recibido', 0);
        return $data->paginate();
    }

    public function find($id) {
        $item = OrdenCompra::with(['proveedor', 'items', 'tipo', 'items.articulo'])->find($id);
        if ($item) {
            // $item->permissions = $item->permissions()->pluck('id');
            return $item;
        }
        return response()->json(['message' => $this->name . ' not found'], 404);
    }

    public function store(Request $request, $id = null) {
        dd(request()->all());
        $request->validate([
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);
        // store a new item
        if ($id && ! $request->has('__form-input-copy') ) {
            $item = OrdenCompra::find($id);
        } else {
            $item = new OrdenCompra;
        }
        $item->code = $request->code;
        $item->name = $request->name;
        $item->description = $request->description;
        $item->{'stock-min'} = $request->{'stock-min'};
        $item->tipo_articulo_id = $request->tipo_articulo_id;
        $item->save();

        return $item;
    }

    public function delete($id) {
        $item = OrdenCompra::find($id);
        $item->delete();
        return $item;
    }

    public function restore($id) {
        $item = OrdenCompra::withTrashed()->find($id);
        $item->restore();
        return $item;
    }

    public function destroy($id) {
        $item = OrdenCompra::withTrashed()->find($id);
        $item->forceDelete();
        return $item;
    }
    public function listSelect(Request $request) {
        $data = OrdenCompra::orderBy('id', 'desc');
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