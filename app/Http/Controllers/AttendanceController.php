<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\AreaServant;
use App\Models\Attendance;
use App\Models\ChapterServant;
use App\Models\HouseholdServant;
use App\Models\Kids;
use App\Models\Member;
use App\Models\UnitServant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $roleId = $user->role_id;
        $sectionId = $user->section_id;

        switch ($roleId) {
            case 6:
                $members = $this->getServantMembers(Member::class, 'household_servant_id', $user->household_servant->id, $sectionId);
                $options = $this->getServantMembers(Member::class, 'household_servant_id', null, $sectionId, 'role_id', 7);
                break;
            case 5:
                $members = $this->getServantMembers(HouseholdServant::class, 'unit_servant_id', $user->unit_servant->id, $sectionId);
                $options = $this->getServantMembers(HouseholdServant::class, 'unit_servant_id', null, $sectionId, 'role_id', 6);
                break;
            case 4:
                $members = $this->getServantMembers(UnitServant::class, 'chapter_servant_id', $user->chapter_servant->id, $sectionId);
                $options = $this->getServantMembers(UnitServant::class, 'chapter_servant_id', null, $sectionId, 'role_id', 5);
                break;
            case 3:
                $members = $this->getServantMembers(ChapterServant::class, 'area_servant_id', $user->area_servant->id, $sectionId);
                $options = $this->getServantMembers(ChapterServant::class, 'area_servant_id', null, $sectionId, 'role_id', 4);
                break;
            default:
                $members = User::all();
                $options = User::all();
        }

        if ($request->ajax()) {
            return DataTables::of($members)
                ->addIndexColumn()
                ->addColumn('name', function ($data) use ($roleId) {
                    return ($roleId == 1 || $roleId == 2) ? $data->name : $data->user->name;
                })
                ->make(true);
        }

        $ids = $mem_role_id = [];

        foreach ($members as $member) {
            $ids[] = ($roleId == 1 || $roleId == 2) ? $member->id : $member->user->id;
            $mem_role_id[] = ($roleId == 1 || $roleId == 2) ? null : $member->user->role_id;
        }

        $attendance = ($roleId == 1 || $roleId == 2)
            ? $this->getAttendanceByUserIds($ids)
            : $this->getAttendanceByRoleIds($mem_role_id);

        return view('attendance.index', compact('attendance', 'members', 'roleId', 'options'));
    }

    private function getServantMembers($model, $relationKey, $relationValue, $sectionId, $whereKey = null, $whereValue = null)
    {
        $query = $model::where($relationKey, $relationValue)
            ->with('user')
            ->whereHas('user', function ($query) use ($sectionId, $whereKey, $whereValue) {
                $query->where('section_id', $sectionId);
                if ($whereKey && $whereValue) {
                    $query->where($whereKey, $whereValue);
                }
            });

        return $query->get();
    }

    // Common function to get attendance by user ids
    private function getAttendanceByUserIds($ids)
    {
        return Attendance::with('activity')
            ->whereHas('activity', function ($q) use ($ids) {
                foreach ($ids as $id) {
                    $q->orWhereJsonContains('user_ids', $id);
                }
            })->get();
    }

    // Common function to get attendance by role ids
    private function getAttendanceByRoleIds($roleIds)
    {
        return Attendance::with('activity')
            ->whereHas('activity', function ($q) use ($roleIds) {
                $q->whereJsonContains('role_ids', $roleIds);
            })->get();
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('attendance.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $roleId = $user->role_id;
        $sectionId = $user->section_id;
        $id = $request->id;

        switch ($roleId) {
            case 6: // Household
                $member = Member::findOrFail($id);
                $household = HouseholdServant::where('user_id', $user->id)->first();
                $userIds = $this->updateUserIds($member, $household, $roleId, $sectionId);
                break;

            case 5: // Unit
                $household = HouseholdServant::findOrFail($id);
                $unit = UnitServant::where('user_id', $user->id)->first();
                $userIds = $this->updateUserIds($household, $unit, $roleId, $sectionId);
                break;

            case 4: // Chapter
                $unit = UnitServant::findOrFail($id);
                $chapter = ChapterServant::where('user_id', $user->id)->first();
                $userIds = $this->updateUserIds($unit, $chapter, $roleId, $sectionId);
                break;

            case 3: // Area
                $chapter = ChapterServant::findOrFail($id);
                $area = AreaServant::where('user_id', $user->id)->first();
                $userIds = $this->updateUserIds($chapter, $area, $roleId, $sectionId);
                break;
        }

        $attendance = Attendance::with('activity')
            ->whereHas('activity', function ($q) use ($roleId) {
                $q->whereJsonContains('role_ids', $roleId);
            })->get();

        foreach ($attendance as $data) {
            $act_id = $data->activity->id;
            $activity = Activity::findOrFail($act_id);

            $existingUserIds = json_decode($activity->user_ids, true) ?? [];
            $existingUserIds[] = $userIds;

            $activity->update(['user_ids' => json_encode(array_values($existingUserIds))]);
            $activity->save();
        }

        return redirect()->back()->with('success', 'Member added successfully');
    }

    private function updateUserIds($main, $dependent, $roleId, $sectionId)
    {
        $user = Auth::user();
        $main->update([$dependent->getForeignKey() => $dependent->id]);

        $dependents = $main::where($dependent->getForeignKey(), optional($user->$dependent)->id)
            ->with('user')
            ->whereHas('user', function ($query) use ($sectionId) {
                $query->where('section_id', $sectionId);
            })->first();

        return optional($dependents)->user->id ?? null;
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
        $attendee_id = $request->attendee_id;
        $status = $request->status;

        $attendance = Attendance::where('activity_id', $id)->first();
        $existingAttendeeIds = json_decode($attendance->attendee_ids, true) ?? [];

        if ($status == "true") {
            // Add the new attendee_id to the array if it doesn't exist
            if (!in_array($attendee_id, $existingAttendeeIds)) {
                $existingAttendeeIds[] = $attendee_id;

                // Update the attendee_ids column
                $attendance->update(['attendee_ids' => json_encode($existingAttendeeIds)]);

                // Save the attendance record after updating the attendee_ids
                $attendance->save();
            }
            return response()->json(['message' => 'Attendance updated successfully'], 200);
        } else {
            // Remove the attendee_id from the array if it exists
            if (($key = array_search($attendee_id, $existingAttendeeIds)) !== false) {
                unset($existingAttendeeIds[$key]);

                // Update the attendee_ids column
                $attendance->update(['attendee_ids' => json_encode(array_values($existingAttendeeIds))]);

                // Save the attendance record after updating the attendee_ids
                $attendance->save();
            }
            return response()->json(['message' => 'Attendance updated successfully'], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
