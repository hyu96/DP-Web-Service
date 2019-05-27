<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DisabilityController extends Controller
{
    public function index()
    {
        return view('disability.index');
    }

    public function show($id)
    {
        return view('disability.show')->with(['id' => $id]);
    }
}
