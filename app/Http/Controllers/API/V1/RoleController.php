<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::whereNotIn('name', ['admin'])->get();
        return response()->json([
            'data' => $roles,
        ], 200);
    }

    public function store(Request $request)
    {
        
        $validated = $request->validate(['name' => ['required', 'min:3']]);
        $role = Role::create($validated);

        return response()->json([
            'message' => 'Role Created Successfully',
            'data' => $role,
        ], 201);
    }

    public function show(Role $role)
    {
        return response()->json([
            'data' => $role,
        ], 200);
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate(['name' => ['required', 'min:3']]);
        $role->update($validated);

        return response()->json([
            'message' => 'Role Updated Successfully',
            'data' => $role,
        ], 201);    }

    public function givePermission(Request $request, Role $role)
    {
        try {
            $permission = Permission::findOrFail($request->permission);

            if ($role->hasPermissionTo($permission)) {
                return response()->json(['message' => 'Permission already exists for this role.'], 400);
            }

            $role->givePermissionTo($permission);

            return response()->json(['message' => 'Permission added to role successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Permission or Role not found.', 'error' => $e->getMessage()], 404);
        }
    }

    public function revokePermission(Role $role, Permission $permission)
    {
        try {
            if (!$role->hasPermissionTo($permission)) {
                return response()->json(['message' => 'Role does not have this permission.'], 400);
            }

            $role->revokePermissionTo($permission);

            return response()->json(['message' => 'Permission revoked from role successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Permission or Role not found.', 'error' => $e->getMessage()], 404);
        }
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return response()->json([
            'message' => 'Role Deleted Successfully',
        ], 200);    
    }
}
