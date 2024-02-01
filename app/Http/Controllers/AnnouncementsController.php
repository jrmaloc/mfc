<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\User;
use App\Notifications\AnnouncementNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Yajra\DataTables\DataTables;

class AnnouncementsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Announcement::all();

            return DataTables::of($data)
                ->addColumn('actions', function ($data) {
                    $actions = '<a href="javascript:void(0);" onclick="show(' . $data['id'] . ')" class="btn mr-2 btn-outline-primary btn-sm"><i class="tf-icons mdi mdi-eye"></i></a>';

                    if (auth()->user()->can('view-household')) {
                        $actions .= '<a href="javascript:void(0);" onclick="edit(' . $data['id'] . ')" class="btn mr-1 btn-outline-info btn-sm"><i class="tf-icons mdi mdi-pencil"></i></a>
                     <a href="javascript:void(0);" id="' . $data['id'] . '" class="btn btn-outline-danger remove-btn btn-sm"><i class="tf-icons mdi mdi-trash-can"></i></a>';
                    }

                    return $actions;
                })
                ->rawColumns(['roles', 'actions'])
                ->make(true);
        }

        return view('announcements.index');
    }

    public function create()
    {
        return view('announcements.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'description' => 'required',
            'title' => 'required',
            'created_at' => 'format:date',
        ]);

        $announcement = Announcement::create($data);

        $admins = User::whereHas('roles', function ($query) {
            $query->whereIn('id', [1, 2, 3, 4, 5, 6, 7]); // Use whereIn for multiple IDs
        })->get();

        Notification::send($admins, new AnnouncementNotification($announcement, 'There is a new announcement! Check it now.'));

        return redirect(route('announcements.index'))->with('success', 'Announcement created successfully');
    }

    public function show(Request $request, string $id)
    {
        $announcement = Announcement::findOrFail($id);

        $redirect = route('announcements.show', ['announcement' => $id]);

        if($request->ajax()) {
            return response()->json(['redirect' => $redirect]);
        };

        return view('announcements.show', [
            'announcement' => $id,
            'data' => $announcement,
        ]);
    }

    public function edit($id)
    {
        $announcement = Announcement::find($id);
        return response()->json($announcement);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $announcement = Announcement::findOrFail($id);
        $announcement->update($data);

        $admins = User::whereHas('roles', function ($query) {
            $query->whereIn('id', [1, 2, 3, 4, 5, 6, 7]); // Use whereIn for multiple IDs
        })->get();

        Notification::send($admins, new AnnouncementNotification($announcement, 'An announcement has been updated! Check it now.'));

        return redirect(route('announcements.index'))->with('success', 'Announcement edited successfully');
    }

    public function destroy(string $id)
    {
        $data = Announcement::findOrFail($id);
        $remove = $data->delete();

        if ($remove) {
            return response([
                'status' => true,
                'message' => 'Announcement deleted successfully'
            ]);
        } else {
            dd("error");
        }
    }
}
