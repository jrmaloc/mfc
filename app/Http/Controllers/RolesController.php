<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Apply auth middleware to this controller
        $this->middleware('permission:view-role', ['only' => ['index']]);
        $this->middleware('permission:create-role', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-role', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-role', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $roles = User::where('role_id', 1)->get();
        $permissions = Permission::all();
        if ($request->ajax()) {
            $data = $roles;

            return DataTables::of($data)
                ->addColumn('actions', function ($data) {
                    return '<a href="javascript:void(0);" id="' . $data->id . '" class="btn btn-outline-primary btn-sm show-btn" data-bs-toggle="offcanvas" data-bs-target="#showCanvas" aria-controls="showCanvas"><i class="tf-icons mdi mdi-eye"></i></a>';
                })
                ->rawColumns(['roles', 'actions'])
                ->make(true);
        }
        return view('roles.super-admin-index', [
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            // Fetch role ID
            $role = User::where('role_id', $id)->first();

            $role_id = $role->role_id;

            if (!$role) {
                // Handle the case when the role is not found
                return response()->json(['error' => 'Error retrieving important data'], 404);
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
    public function update(Request $request, $id)
    {
        dd($request->all());
        // Validate the request data
        // $data = $request->validate([
        //     'name' => 'required',
        //     'permission' => 'required|array', // Assuming permissions are submitted as an array
        // ]);

        // // Find the role by ID
        // $role = User::findOrFail($id);

        // // Update the role name
        // $role->name = $data['name'];

        // // Sync permissions for the role
        // if (isset($data['permission'])) {
        //     $permissions = Permission::whereIn('id', $data['permission'])->get();
        //     $role->syncPermissions($permissions);
        // } else {
        //     // If no permissions are selected, you might want to handle this case accordingly
        //     // For example, removing all permissions for the role
        //     return redirect()->back()->with('error', 'There is no permissions selected');
        // }

        // // Save the changes to the role
        // $role->save();

        // // Optionally, redirect to the roles index or wherever is appropriate
        // return redirect()->route('roles.index')->with('success', 'Role updated successfully!');
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
                    'delete' => 'User demoted to member role'
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
