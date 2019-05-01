<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Disability;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\UserDisability;
use App\Models\UserNeed;
use App\Models\Need;
use App\Models\User;

class ReportController extends Controller
{
    public function all()
    {
        return view('report.all');
    }
}
