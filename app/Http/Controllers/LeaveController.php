<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\allLeave;
use App\Models\Employee;
use App\Models\leaveType;
use Illuminate\Support\Carbon;
use PhpParser\Node\Stmt\If_;

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
        $userExist = Employee::where('staff_id',$user)->first();
        $approvalCheck = allLeave::where('staff_id',$user)->pluck('application_status')->implode('');
        $sharedLeave = allLeave::where('staff_id',$user)
                                    ->where('application_status','Applied')
                                    ->orWhere('application_status','REGISTRY has Approve')
                                    ->orWhere('application_status','VC has Approve')->pluck('shared_leave')->implode('');
        $sharedDays = allLeave::where('staff_id',$user)
                                    ->where('application_status','Applied')->pluck('shared_days')->first();
        $department = Employee::where('staff_id','=',$user)->pluck("department")->first();

        if($userExist){
            //dd("User Exist");
                if(in_array($approvalCheck, array('HOD has Recommend', 'PROVOST has Recommend'))){
                    //Checks if the applicant has a pending application thats not yet approved or approval not complete
                    var_dump("Your application is awating approval");
                }elseif($approvalCheck == "Applied"){
                    if($sharedLeave == "YES"){
                        //dd("Your shared leave is YES");
                        //Application for those that shared leave
                        if($request->isMethod('POST')){
                            $all_leave = new allLeave;
                            $all_leave->staff_id = $user;
                            $all_leave->department = $department;
                            $all_leave->leave_type = $request->input('leaveType');
                                $leaveDays = leaveType::all()->where('leave_type','=',$all_leave->leave_type)->pluck('leave_days');
                                $leaveDays = empty($leaveDays[0]) ? 0 :  $leaveDays[0];
                            $all_leave->start_date = $request->input('dateFrom');
                            $all_leave->leave_days = $leaveDays;
                            $remainingDays = $all_leave->leave_days - $sharedDays;
                            $newTime = date('d-m-Y', (strtotime($all_leave->start_date.' + '.$remainingDays.' days')));
                            $newDate = date('Y-m-d', strtotime($newTime));
                            $all_leave->end_date = $newDate;
                            $all_leave->default_days = $leaveDays;
                            $all_leave->days_applied_for = $leaveDays;
                            $all_leave->leave_description = $request->input('description');
                            $all_leave->save();
                        }
                    }elseif($sharedLeave == "NO"){
                        echo "<script>";
                        echo "alert('hello');";
                        echo "</script>";
                        //var_dump("Your shared leave is No");
                        // If No then it means no shared leave and can only apply if all aprovals are complete for previous application
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
                    }else var_dump("Neither No nor Yes");
                }else var_dump("Neither Approval nor Applied");
            //Fresh application, For users that has never applied before
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
        }else dd("User does not exist");
        
        $leaveType = leaveType::pluck('leave_type','leave_days');
        $allLeave = allLeave::all()->where('staff_id','=',$user);

        return view('leave.application', ['leave_t' => $leaveType, 'all_l' => $allLeave, 'sharedDays' => $sharedDays]);
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

    public function applied()
    {
        $user = Auth::user()->name;
        $staffDepartment = allLeave::where('staff_id','=',$user)->pluck("department")->first();
        $allLeave = allLeave::all()->where('department', $staffDepartment)
                                    ->where('created_at', date('Y-m-d'));
        // Articles::whereYear('created_at', date('Y'))->get();
    
        return view('leave.applied', ['all_l' => $allLeave]);
    }

    public function approval(Request $request, $id) {
        //Approval page
        if($request->isMethod('POST')){
            switch ($request->input('submitButton')){
                case 'HOD RECOMMEND':
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

                case 'HOD DO NOT RECOMMEND':
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

                case 'PROVOST RECOMMEND':
                    //Provost approval
                    $allLeave = allLeave::find($id);
                    $allLeave->provost_remark = $request->input('provostRemark');
                    $allLeave->save();

                    allLeave::where('id',"{$id}")->update(['application_status' => 'PROVOST has approved']);
                    return redirect('applied');
                break;

                case 'PROVOST DO NOT RECOMMEND':
                    //Provost Declined
                    $allLeave = allLeave::find($id);
                    $allLeave->provost_remark = $request->input('provostRemark');
                    $allLeave->save();

                    allLeave::where('id',"{$id}")->update(['application_status' => 'PROVOST has declined']);
                    return redirect('applied');
                break;

                case 'REGISTRY APPROVE':
                    //Registry approval
                    $allLeave = allLeave::find($id);
                    $allLeave->registry_remark = $request->input('registryRemark');
                    $allLeave->save();

                    allLeave::where('id',"{$id}")->update(['application_status' => 'REGISTRY has approved']);
                    return redirect('applied');
                break;

                case 'REGISTRY DECLINE':
                    //Registry Declined
                    $allLeave = allLeave::find($id);
                    $allLeave->registry_remark = $request->input('registryRemark');
                    $allLeave->save();

                    allLeave::where('id',"{$id}")->update(['application_status' => 'REGISTRY has declined']);
                    return redirect('applied');
                break;

                case 'VC APPROVE':
                    //VC approval
                    allLeave::where('id',"{$id}")->update(['application_status' => 'VC has approved']);
                    return redirect('applied');
                break;

                case 'VC DECLINE':
                    //VC Declined
                    allLeave::where('id',"{$id}")->update(['application_status' => 'VC has declined']);
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
