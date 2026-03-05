<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Almacen;

class AlmacenController extends Controller {
    private $model = Almacen::class;
    private $name = 'Almacen';
    private $prefixPermission = 'almacen';

    public function all() {
        // sniff($this->prefixPermission . '-*');
        $data = $this->model::orderBy('id', 'desc');
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
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
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
        $data = $this->model::orderBy('id', 'desc');
        if ( request()->has('search') && strlen(request()->search) ) {
            $data->where(function($query) {
                $keys = ['code', 'name'];
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
}