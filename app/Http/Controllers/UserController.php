<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Disability;
use App\Models\Need;
use App\Models\UserNeed;
use App\Models\District;
use App\Models\Subdistrict;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index()
    {
        return view('user.list');
    }

    public function show(Request $request, $id)
    {
        $disabilities = Disability::all()->pluck('name', 'id');
        $needs = Need::all();
        return view('user.show')->with([
            'id' => $id,
            'disabilities' => $disabilities,
            'needs' => $needs
        ]);
    }

    public function create()
    {
        $district = District::find(Auth::user()->district_id);
        $disabilities = Disability::all()->pluck('name', 'id');
        $needs = Need::all();
        return view('user.create')->with([
            'district' => $district,
            'disabilities' => $disabilities,
            'needs' => $needs
        ]);
    }

    public function showUserImport()
    {
        $district = District::find(Auth::user()->district_id);
        return view('user.import')->with([
            'district' => $district
        ]);
    }

    public function showUserExport()
    {
        $role = Auth::user()->role;
        if ($role === Admin::CITY_ADMIN) {
            return view('user.export-city');
        } else {
            $district = District::find(Auth::user()->district_id);
            return view('user.export-district')->with([
                'district' => $district
            ]);
        }
    }

    public function exportUser(Request $request)
    {
        try {
            return Excel::download(new UsersExport($request->district_id, $request->subdistrict_id), 'users.xlsx');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
        }
    }
}
