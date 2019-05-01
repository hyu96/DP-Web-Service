<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Subdistrict;
use App\Models\Role;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.list');
    }

    public function create()
    {
    	$districts = District::all();
        $subdistricts = Subdistrict::all();
        if (Auth::guard('admin')->user()->hasRole('superadministrator')) {
            $roles = Role::whereIn('name', ['superadministrator', 'district_administrator', 'subdistrict_administrator'])->get();
        } else if (Auth::guard('admin')->user()->hasRole('district_administrator')) {
            $roles = Role::whereIn('name', ['district_administrator', 'subdistrict_administrator'])->get();
        } else {
            $roles = Role::whereIn('name', ['subdistrict_administrator'])->get();
        }
        return view('admin.admin.create')->with([
        	'districts' => $districts,
        	'subdistricts' => $subdistricts,
            'roles' => $roles
        ]);
    }

}
