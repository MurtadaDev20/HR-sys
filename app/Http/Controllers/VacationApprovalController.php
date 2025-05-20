<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Illuminate\Http\Request;

class VacationApprovalController extends Controller
{
    public function index()
    {
        return view('employ.vacation-approval');
    }
}
