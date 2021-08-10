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
            $all_leave->staff_id = $user;
            $all_leave->department = $department;
            $all_leave->leave_type = $request->input('leaveType');
            $all_leave->start_date = $request->input('dateFrom');
                $leaveDays = leaveType::all()->where('leave_type','=',$all_leave->leave_type)->pluck('leave_days');
                $leaveDays = empty($leaveDays[0]) ? 0 :  $leaveDays[0];
            $all_leave->leave_days = $leaveDays;
            $newTime = date('d-m-Y', (strtotime($all_leave->start_date.' + '.$leaveDays.' days')));
            $newDate = date('Y-m-d', strtotime($newTime));
            $all_leave->end_date = $newDate;
            $all_leave->default_days = $leaveDays;
            $all_leave->days_applied_for = $leaveDays;
            $all_leave->leave_description = $request->input('description');
            $all_leave->save();
        }
        
        $leaveType = leaveType::pluck('leave_type','leave_days');
        $allLeave = allLeave::all()->where('staff_id','=',$user);

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
    public function show()
    {
        //Displaying the details of all the Leave applied for
        $allLeave = allLeave::all();
        $department = allLeave::all()->pluck('department');
        $noOfStaffInDepartment = allLeave::where('department',$department)->count();

        return view('leave.allLeave', ['all_l' => $allLeave, 'number' => $noOfStaffInDepartment]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        //Edit Application
        if($request->isMethod('POST')){

            $all_leave = allLeave::find($id);
            $all_leave->leave_type = $request->input('leaveType');
            $all_leave->date_from = $request->input('dateFrom');
                $leaveDays = leaveType::all()->where('leave_type','=',$all_leave->leave_type)->pluck('leave_days');
                $leaveDays = empty($leaveDays[0]) ? 0 :  $leaveDays[0];
            $all_leave->leave_days = $leaveDays;
            $newTime = date('d-m-Y', (strtotime($all_leave->date_from.' + '.$leaveDays.' days')));
            $newDate = date('Y-m-d', strtotime($newTime));
            $all_leave->date_to = $newDate;
            $all_leave->description = $request->input('description');
            $all_leave->save();

            return redirect('application');
        }

        $applications = allLeave::find($id);
        $leaveType = leaveType::pluck('leave_type','leave_type');

        return view('leave.editApplication', ['application' => $applications, 'leave_t' => $leaveType,]);
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

    public function applied(){
        $user = Auth::user()->name;
        $linkUser = allLeave::where('staff_id','=',$user)->pluck("department")->first();
        $allLeave = allLeave::all()->where('department','=', $linkUser);
    
        return view('leave.applied', ['all_l' => $allLeave, 'linkUsers' => $linkUser]);
    }

    public function approval(Request $request, $id) {
        //Approval page
        if($request->isMethod('POST')){
            switch ($request->input('submitButton')){
                case 'HOD APPROVE':
                    //HOD Approval
                    $allLeave = allLeave::find($id);
                    $allLeave->hod_remark = $request->input('hodRemark');
                    $allLeave->save();

                    // if (Employee::where('employee_id',"{$employee_id}")->pluck('employee_category')->first() == 'Non-Teaching') {
                    //     allLeave::where('employee_id',"{$employee_id}")->update(['application_status' => 'PROVOST has approved']);
                    // }else
                    allLeave::where('id',"{$id}")->update(['application_status' => 'HOD has Approved']);
                    return redirect('applied');
                break;

                case 'HOD DECLINE':
                    //HOD Decline
                    //Employee::find($employee_id);
                    $allLeave = allLeave::find($id);
                    $allLeave->hod_remark = $request->input('hodRemark');
                    $allLeave->save();

                    // if (Employee::where('employee_id',"{$employee_id}")->pluck('employee_category')->first() == 'Non-Teaching') {
                    //     allLeave::where('employee_id',"{$employee_id}")->update(['application_status' => 'HOD has declined']);
                    // }else
                    allLeave::where('id',"{$id}")->update(['application_status' => 'HOD has declined']);
                    return redirect('applied');
                break;

                case 'PROVOST APPROVE':
                    //Provost approval
                    $allLeave = allLeave::find($id);
                    $allLeave->provost_remark = $request->input('provostRemark');
                    $allLeave->save();

                    allLeave::where('id',"{$id}")->update(['application_status' => 'PROVOST has approved']);
                    return redirect('applied');
                break;

                case 'PROVOST DECLINE':
                    //Provost Declined
                    $allLeave = allLeave::find($id);
                    $allLeave->provost_remark = $request->input('provostRemark');
                    $allLeave->save();

                    allLeave::where('id',"{$id}")->update(['application_status' => 'PROVOST has declined']);
                    return redirect('applied');
                break;

                case 'REGISTRY APPROVE':
                    //Registry approval
                    allLeave::where('id',"{$id}")->update(['application_status' => 'REGISTRY has approved']);

                    return redirect('applied');
                break;

                case 'REGISTRY DECLINE':
                    //Registry Declined
                    allLeave::where('id',"{$id}")->update(['application_status' => 'REGISTRY has declined']);

                    return redirect('applied');
                break;
            }
        }
        $allLeave = allLeave::find($id);
        return view('leave/approval')->with('all_l',$allLeave);
    }

    public function getApprovedLeave (){

        return view('leave.approved');
    }

    public function getleaveViewDetails($staff_id,$id){
        //view applicant details 
        $employee = Employee::whereStaff_id($staff_id)->first();
        $leave = allLeave::where('id',"{$id}")->first();
        $leaves = allLeave::all()->where('staff_id',"{$staff_id}");

        return view('leave.leaveViewDetails', ['emp' => $employee, 'leave' => $leave, 'leave_details' => $leaves]);
    }
}
