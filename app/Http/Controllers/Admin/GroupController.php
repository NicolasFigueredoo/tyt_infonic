<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Junges\ACL\Models\Group;

class GroupController extends Controller {
    public function all() {
        // sniff('group-*');
        return Group::orderBy('id', 'desc')->paginate();
    }

    public function find($id) {
        $group = Group::find($id);
        if ($group) {
            $group->permissions = $group->permissions()->pluck('id');
            return $group;
        }
        return response()->json(['message' => 'Group not found'], 404);
    }

    public function store(Request $request, $id = null) {
        // validate the request
        $request->validate([
            'name'        => 'required|string|max:255|unique:groups' . ($id ? ",id,$id" : ''),
            'guard_name'  => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);
        // store a new item
        if ($id) {
            $item = Group::find($id);
        } else {
            $item = new Group;
        }
        $item->name        = $request->name;
        $item->guard_name  = $request->guard_name;
        $item->description = $request->description;
        $item->save();

        // sync permissions
        $permissions = [];
        if ($request->has('permissions') && strlen($request->permissions)) {
            $permissions = explode(',', $request->permissions);
        }
        if (is_array($permissions) && count($permissions)) {
            $item->permissions()->sync($permissions);
        }
        return $item;
    }

    public function delete($id) {
        $item = Group::find($id);
        $item->delete();
        return $item;
    }

    public function restore($id) {
        $item = Group::withTrashed()->find($id);
        $item->restore();
        return $item;
    }

    public function destroy($id) {
        $item = Group::withTrashed()->find($id);
        $item->forceDelete();
        return $item;
    }
}