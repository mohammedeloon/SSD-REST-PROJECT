<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return response()->json(['data' => $permissions], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate(['name' => 'required|min:3']);
        $permission = Permission::create($validated);

        return response()->json(['message' => 'Permission created.', 'data' => $permission], 201);
    }

    public function show(Permission $permission)
    {
        return response()->json(['data' => $permission], 200);
    }

    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate(['name' => 'required']);
        $permission->update($validated);

        return response()->json(['message' => 'Permission updated.', 'data' => $permission], 200);
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();

        return response()->json(['message' => 'Permission deleted.'], 200);
    }

    public function assignRole(Request $request, Permission $permission)
    {
        try {
            $role = Role::findOrFail($request->role);

            if ($permission->hasRole($role)) {
                return response()->json(['message' => 'Role exists.'], 400);
            }

            $permission->assignRole($role);
            return response()->json(['message' => 'Role assigned.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Role or Permission not found.', 'error' => $e->getMessage()], 404);
        }
    }

    public function removeRole(Permission $permission, Role $role)
    {
        try {
            if ($permission->hasRole($role)) {
                $permission->removeRole($role);
                return response()->json(['message' => 'Role removed.'], 200);
            }

            return response()->json(['message' => 'Role not exists.'], 400);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Role or Permission not found.', 'error' => $e->getMessage()], 404);
        }
    }
}
