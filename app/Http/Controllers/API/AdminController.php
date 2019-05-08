<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class AdminController extends BaseController
{
    public function index()
	{
		$admins = Admin::with(['district'])->get();
		return $this->responseSuccess(200, $admins);
	}

    public function store(Request $request)
    {
        $data = $request->all();
        $messages = [
            'required' => 'Giá trị :attribute không được trống.',
            'string' => 'Giá trị của :attribute phải là chuỗi kí tự',
            'email' => 'Địa chỉ email không hợp lệ',
            'integer' => 'Giá trị của :attribute phải là số',
            'size' => 'Giá trị của :attribute phải có :size kí tự',
            'min' => 'Giá trị của :attribute ít nhất phải có :min kí tự',
            'regex' => 'Giá trị của :attribute phải là chuỗi chữ số',
            'unique' => ':attribute đã được sử dụng',
        ];

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'identity_card' => ['required', 'string', 'size:9', 'regex:/^([0-9]+)$/', 'unique:admins'],
            'phone' => ['required', 'string', 'min:10', 'regex:/^([0-9]+)$/'],
            'birthday' => ['required', 'date'],
            'gender' => ['required', Rule::in(['male', 'female'])],
        ], $messages);

        if ($validator->fails()) {
            return $this->responseErrors(400, $validator->errors());
        }

        $admin = Admin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'identity_card' => $data['identity_card'],
            'birthday' => $data['birthday'],
            'gender' => $data['gender'],
            'role' => $data['role'],
            'district_id' => $data['role'] === '0' ? null : $data['district_id'],
        ]);

        return $this->responseSuccess(200, $admin);
    }

    public function delete($id)
    {
        $admin = Admin::find($id);
        if ($admin === null) {
            return $this->responseErrors(400, 'Admin not found');
        } else {
            $admin->delete();
            return $this->responseSuccess(200, 'Delete success');
        }
    }
}
