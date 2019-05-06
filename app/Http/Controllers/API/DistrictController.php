<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Models\District;

class DistrictController extends BaseController
{
	public function index()
	{
		$districts = District::all();
		return $this->responseSuccess(200, $districts);
	}

    public function show($id)
    {
        $district = District::find($id);
        return $this->responseSuccess(200, $district);
    }
}
