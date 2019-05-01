<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
	public function responseSuccess($statusCode = 200, $data) {
		return response()->json([
            'success' => true,
			'data' => $data
		], $statusCode);
	}

    public function responseErrors($statusCode = 500, $data) {
        return response()->json([
            'success' => false,
            'messages' => $data
        ], $statusCode);
    }
}
