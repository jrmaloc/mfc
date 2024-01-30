<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $roles = User::where('role_id', 2)->get();

        $permissions = Permission::all();

        if ($request->ajax()) {
            $data = $roles;

            return DataTables::of($data)
                ->addColumn('actions', function ($data) {
                    return '<div class="flex gap-1">
                    <a href="javascript:void(0);" onclick="showForm(' . $data['id'] . ')" class="btn btn-outline-primary btn-sm"><i class="tf-icons mdi mdi-eye"></i></a>
                    <a href="javascript:void(0);" id="' . $data->id . '" class="btn btn-outline-danger remove-btn btn-sm"><i class="tf-icons mdi mdi-trash-can"></i></a>
                    </div>';
                })
                ->rawColumns(['roles', 'actions'])
                ->make(true);
        }

        return view('roles.admin-index', [
            'permission' => $permissions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|numeric'
        ], [
            'name.numeric' => 'Please Choose a User to give a role',
        ]);

        $id = $data['name'];
        $user = User::findOrFail($id);
        $info = $user->assignRole('Admin');

        if ($info) {
            $user->role_id = 2;
            $user->save();
        }

        return response()->json([
            'success' => 'Successfully created'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            // Fetch role ID
            $role = User::find($id);

            $role_id = $role->role_id;

            if (!$role) {
                // Handle the case when the role is not found
                return response()->json(['error' => 'Role not found'], 404);
            }

            $permissions = Role::where('id', $role_id)->with('permissions')
                ->whereHas('permissions', function ($q) use ($role_id) {
                    $q->where('role_id', $role_id);
                })->get();

            // Return the permission details along with roles as JSON response
            return response()->json([
                'permissions' => $permissions,
                'role' => $role,
            ]);

        } catch (\Exception $e) {
            // Handle any exceptions or errors that occur
            // You can log the error, return a specific error message, or respond with a specific HTTP status code
            return response()->json(['error' => 'Role not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        $data = $user->assignRole('Member');

        if ($data) {
            $user->role_id = 7;
            $remove = $user->save();

            if ($remove) {
                return response([
                    'status' => true,
                    'message' => 'User demoted to member role'
                ]);
            } else {
                return response([
                    'error' => true,
                    'message' => 'Failed to change user role'
                ]);
            }
        }
    }
}
