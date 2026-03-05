<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Junges\ACL\Models\Permission;

class PermissionController extends Controller {
    public function all() {
        return Permission::orderBy('id', 'desc')->paginate();
    }

    public function find($id) {
        return Permission::find($id);
    }

    public function store(Request $request, $id = null) {
        // validate the request
        $request->validate([
            'name'        => 'required|string|max:255|unique:permissions' . ($id ? ",id,$id" : ''),
            'guard_name'  => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);
        // store a new permission
        if ($id) {
            $permission = Permission::find($id);
        } else {
            $permission = new Permission;
        }
        if ( request()->has('assistant') && request()->assistant == 'crud-basic' ) {
            $permissions = [
                '-data-import' => 'Importar',
                '-data-export' => 'Exportar',
                '-restore'     => 'Restaurar',
                '-delete'      => 'Eliminar',
                '-edit'        => 'Editar',
                '-create'      => 'Crear'
            ];
            foreach ($permissions as $key => $description) {
                $permission = new Permission;
                $permission->group_prefix = $request->group_prefix;
                $permission->name         = $request->name . $key;
                $permission->guard_name   = $request->guard_name;
                $permission->description  = $description . ' ' . $request->description;
                $permission->save();
            }
        } else {
            $permission->group_prefix = $request->group_prefix;
            $permission->name         = $request->name;
            $permission->guard_name   = $request->guard_name;
            $permission->description  = $request->description;
            $permission->save();
        }
        return $permission;
    }

    public function delete($id) {
        $permission = Permission::find($id);
        $permission->delete();
        return $permission;
    }

    public function restore($id) {
        $permission = Permission::withTrashed()->find($id);
        $permission->restore();
        return $permission;
    }
}