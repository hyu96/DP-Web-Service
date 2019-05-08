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

        return view('admin.create')->with([
            'districts' => $districts,
            'subdistricts' => $subdistricts,
        ]);
    }

    public function show($id)
    {
        $districts = District::all();
        $subdistricts = Subdistrict::all();
        $admin = Admin::where('id', $id)->with(['district'])->first();
        return view('admin.show')->with([
            'admin' => $admin,
            'districts' => $districts,
            'subdistricts' => $subdistricts,
            'id' => $id
        ]);
    }
}
