<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:view-permissions|create-permissions|edit-permissions|delete-permissions', ['only' => ['index', 'store']]);
        $this->middleware('permission:create-permissions', ['only' => ['create', 'store', 'edit', 'update']]);
        $this->middleware('permission:edit-permissions', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-permissions', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $permission = Permission::with('roles')->get(); // Eager load roles
            $data = $permission->map(function ($permission) {
                return [
                    'roles' => $permission->roles->pluck('name')->toArray(),
                    'id' => $permission->id,
                    'name' => $permission->name,
                    // Other columns you might have
                ];
            });

            return datatables()->of($data)
                ->addColumn('roles', function ($row) {
                    $rolesHtml = '';
                    foreach ($row['roles'] as $role) {
                        if ($role == 'Admin') {
                            $rolesHtml .= '<span class="admin btn rounded-pill btn-outline-secondary ml-4"> ' . 'Admin' . '</span>';
                        } elseif ($role == 'Super Admin') {
                            $rolesHtml .= '<span class="superadmin btn rounded-pill btn-outline-primary ml-4"> ' . 'Super Admin' . '</span>';
                        } elseif ($role == 'Area Servant') {
                            $rolesHtml .= '<span class="area btn rounded-pill btn-outline-warning ml-4"> ' . 'Area Servant' . '</span>';
                        } elseif ($role == 'Chapter Servant') {
                            $rolesHtml .= '<span class="area btn rounded-pill btn-outline-dark ml-4 capitalize"> ' . 'Chapter Servant' . '</span>';
                        } elseif ($role == 'Unit Servant') {
                            $rolesHtml .= '<span class="area btn rounded-pill btn-outline-info ml-4"> ' . 'Unit Servant' . '</span>';
                        } elseif ($role == 'Household Servant') {
                            $rolesHtml .= '<span class="household btn rounded-pill btn-outline-danger ml-4"> ' . 'Household Servant' . '</span>';
                        } elseif ($role == 'Member') {
                            $rolesHtml .= '<span class="member btn rounded-pill btn-outline-success ml-4"> ' . 'Member' . '</span>';
                        }
                    }
                    return $rolesHtml;
                })
                ->addColumn('actions', function ($permission) {
                    return '<div class="dropdown">
                                <a href="javascript:void(0);" onclick="editPermission(' . $permission['id'] . ')" class="btn btn-outline-info btn-sm"><i class="tf-icons mdi mdi-pencil"></i></a>
                                <a href="javascript:void(0);" id="' . $permission['id'] . '" class="btn btn-outline-danger remove-btn btn-sm"><i class="tf-icons mdi mdi-trash-can"></i></a>
                            </div>';
                })
                ->rawColumns(['roles', 'actions'])
                ->make(true);
        }

        $roles = Role::all();

        return view('permissions.permissions', [
            'roles' => $roles,
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
        // Validate the request
        $request->validate([
            'name' => 'required|unique:permissions,name',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id'
        ]);

        // Create the permission
        $permission = Permission::create([
            'name' => $request->name,
            'guard_name' => 'web' // Adjust the guard as needed
        ]);

        // Assign the permission to selected roles using checkboxes
        foreach ($request->roles as $roleId) {
            $role = Role::findById($roleId);
            $role->givePermissionTo($permission);
        }

        // Redirect or return response as needed
        return redirect()->route('permissions.index')->with('success', 'Permission added successfully');
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
    public function edit(Permission $permission)
    {
        try {
            // Fetch roles related to the permission
            $roles = $permission->roles()->pluck('id')->toArray();

            // Return the permission details along with roles as JSON response
            return response()->json([
                'permission' => $permission,
                'roles' => $roles,
            ]);
        } catch (\Exception $e) {
            // Handle any exceptions or errors that occur
            // You can log the error, return a specific error message, or respond with a specific HTTP status code
            return response()->json(['error' => 'Permission not found'], 404);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {

        $data = $request->validate([
            'name' => 'required',
            'roles' => 'required', // Assuming roles come as an array
        ]);
        $permission->update($data);

        if ($request->has('roles')) {
            $roleIds = array_map('intval', $request->get('roles', []));
            $permission->syncRoles($roleIds);
        }
        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $permission = Permission::findOrFail($request->id);
        $remove = $permission->delete();
        $permission->delete();

        if ($remove) {
            return response([
                'status' => true,
                'message' => 'Permission Deleted Successfully'
            ]);
        }
    }
}
