<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;

class HouseholdServantController extends Controller
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
        $roles = User::where('role_id', 6)->get();

        $permissions = Permission::all();

        if ($request->ajax()) {
            $data = $roles;

            return DataTables::of($data)
                ->addColumn('actions', function ($data) {
                    return '<div class="flex gap-1">
                    <a href="javascript:void(0);" id="' . $data->id . '" class="btn btn-outline-primary show-btn btn-sm" data-bs-toggle="offcanvas" data-bs-target="#showCanvas" aria-controls="showCanvas"><i class="tf-icons mdi mdi-eye"></i></a>
                    <a href="javascript:void(0);" id="' . $data->id . '" class="btn btn-outline-danger remove-btn btn-sm"><i class="tf-icons mdi mdi-trash-can"></i></a>
                    </div>';
                })
                ->rawColumns(['roles', 'actions'])
                ->make(true);
        }

        return view('roles.household-index', [
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
            'name' => 'required|numeric',
        ], [
            'name.required' => 'Please Choose a User to give a role',
            'name.numeric' => 'Please Choose a User to give a role',
        ]);

        $id = $data['name'];
        $user = User::findOrFail($id);
        $info = $user->assignRole('Household Servant');

        if ($info) {
            $user->role_id = 6;
            $user->save();
        }

        return redirect()->route('household.index')->with('success', 'Successfully added');
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
        //
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
        //
    }
}
