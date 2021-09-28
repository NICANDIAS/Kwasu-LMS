<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\activity_log;
use App\Models\User;

class ActivityLogController extends Controller
{
    Public function index()
    {
        // $causer_id = User::
        $log = activity_log::all();
        return view('leave.log',['log' => $log]);
    }
}
