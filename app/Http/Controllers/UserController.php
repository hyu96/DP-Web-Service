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
        $admin = Auth::user();
        $user = User::find($id);
        if (empty($user)) {
            return abort('404');
        }

        if ($admin->role === 1) {
            if ($admin->district_id !== $user->district_id) {
                return abort('404');
            }
        }


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
        if (Auth::user()->role === 0) {
            return abort('404');
        }
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
            $district_id = $request->district_id;
            if ($district_id === null) {
                $district_id = Auth::user()->district_id;
            }
            $district = District::find($district_id);
            $subdistrict = Subdistrict::find($request->subdistrict_id);
            return Excel::download(new UsersExport($district_id, $request->subdistrict_id), $district->name. ' - '. $subdistrict->name. '.xlsx');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
        }
    }

    public function importTemplate()
    {
        return response()->download(public_path().'/files/import-template.xlsx');
    }
}
