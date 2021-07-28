<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\allLeave;
use App\Models\Employee;
use App\Models\leaveType;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user()->name;
        $department = Employee::where('staff_id','=',$user)->pluck("department")->first();
        //$request->user();

        if($request->isMethod('POST')){
            $all_leave = new allLeave;
            $all_leave->employee_id = $user;
            $all_leave->department = $department;
            $all_leave->leave_type = $request->input('leaveType');
            $all_leave->date_from = $request->input('dateFrom');
                $leaveDays = leaveType::all()->where('leave_type','=',$all_leave->leave_type)->pluck('leave_days');
                $leaveDays = empty($leaveDays[0]) ? 0 :  $leaveDays[0];
            $all_leave->leave_days = $leaveDays;
            $newTime = date('d-m-Y', (strtotime($all_leave->date_from.' + '.$leaveDays.' days')));
            $newDate = date('Y-m-d', strtotime($newTime));
            $all_leave->date_to = $newDate;
            $all_leave->default_days = $leaveDays;
            $all_leave->days_applied_for = $leaveDays;
            $all_leave->description = $request->input('description');
            $all_leave->save();
        }
        
        $leaveType = leaveType::pluck('leave_type','leave_type');
        $allLeave = allLeave::all()->where('employee_id','=',$user);

        return view('leave.application', ['leave_t' => $leaveType, 'all_l' => $allLeave]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
