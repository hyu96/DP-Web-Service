<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class AdminController extends BaseController
{
    public function index()
	{
        $admin = Auth::user();
        if ($admin->role === Admin::CITY_ADMIN) {
    		$admins = Admin::with(['district'])->get();
        } else {
            $admins = Admin::where('district_id', $admin->district_id)->get();
        }
		return $this->responseSuccess(200, $admins);
	}
}
