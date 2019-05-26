<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\Subdistrict;

class SubdistrictController extends BaseController
{
    public function index(Request $request)
    {
        $district_id = $request->query('district');
        if (empty($district_id)) {
            $subdistricts = Subdistrict::all()->toArray();
        } else {
            $subdistricts = Subdistrict::where('district_id', $district_id)->get()->toArray();
        }
        return $this->responseSuccess(200, $subdistricts);
    }

    public function show($id)
    {
        $subdistrict = Subdistrict::find($id);
        if (empty($subdistrict)) {
            return $this->responseErrors(404, 'Subdistrict not found');
        }
        return $this->responseSuccess(200, $subdistrict);
    }
}
