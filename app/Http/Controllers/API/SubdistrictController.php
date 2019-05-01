<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\Subdistrict;

class SubdistrictController extends BaseController
{
    public function index()
    {
        $district_id = Auth::user()->district_id;
        $subdistricts = Subdistrict::where('district_id', $district_id)->get()->toArray();
        return $this->responseSuccess(200, $subdistricts);
    }
}
