<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Need;
use App\Models\UserNeed;
use App\Models\Admin;
use App\Http\Controllers\API\BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{
	public function index()
	{
        $admin = Auth::user();
        if ($admin->role === Admin::CITY_ADMIN) {
            $users = User::with(['district', 'subdistrict'])->get();
        } else {
            $users = User::where('district_id', $admin->district_id)->with(['district', 'subdistrict'])->get();
        }
		return $this->responseSuccess(200, $users);
	}

    public function store(Request $request) {
        $data = $request->all();
        $messages = [
            'required' => ':attribute không được trống.',
            'string' => ':attribute phải là chuỗi kí tự',
            'email' => 'Địa chỉ email không hợp lệ',
            'unique' => 'Địa chỉ email đã được sử dụng',
            'integer' => ':attribute phải là số',
            'size' => ':attribute phải có :size kí tự',
            'min' => ':attribute ít nhất phải có :min kí tự',
            'regex' => ':attribute phải là chuỗi chữ số'
        ];

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'identity_card' => ['required', 'string', 'size:9', 'regex:/^([0-9]+)$/'],
            'phone' => ['required', 'string', 'min:10', 'regex:/^([0-9]+)$/'],
            'birthday' => ['required', 'string'],
            'gender' => ['required', Rule::in(['male', 'female'])],
            'address' => ['required', 'string'],
            'employment_status' => ['string'],
            'labor_ability' => ['required', 'boolean'],
            'income' => ['integer'],
            'academic_level' => ['required'],
            'disability' => ['required', 'integer'],
            'disability_detail' => ['required', 'string'],
            'specialize' => ['required', 'string'],
            'subdistrict_id' => ['required', 'integer']
        ], $messages);

        if ($validator->fails()) {
            return $this->responseErrors(400, $validator->errors());
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'identity_card' => $data['identity_card'],
            'birthday' => $data['birthday'],
            'gender' => $data['gender'],
            'address' => $data['address'],
            'disability_id' => $data['disability'],
            'disability_detail' => $data['disability_detail'],
            'employment_status' => $data['employment_status'],
            'labor_ability' => $data['labor_ability'],
            'income' => $data['income'],
            'academic_level' => $data['academic_level'],
            'specialize' => $data['specialize'],
            'district_id' => Auth::user()->district_id,
            'subdistrict_id' => $data['subdistrict_id'],
            'approver_id' => Auth::user()->id,
            'admin_update_id' => null,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $userNeed = $data['need'];
        foreach($userNeed as $need) {
            $dataUserNeed[] = [
                'user_id' => $user->id,
                'need_id' => $need,
                'detail' => $this->getNeedDetail($need, $data),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ];
        }
        UserNeed::insert($dataUserNeed);
        return $this->responseSuccess(200, $user);
    }

    public function show($id)
    {
        $user = User::where('id', $id)->with(['district', 'subdistrict'])->first();
        if ($user === null) {
            return $this->responseErrors(400, 'Thông tin người khuyết tật không tồn tại');
        } else {
            return $this->responseSuccess(200, $user);
        }
    }

    public function edit(Request $request, $id)
    {

    }

    protected function getNeedDetail($need, $data) {
        switch ($need) {
            case Need::HOC_NGHE:
                return $data['user-job-detail'];
                break;

            default:
                return null;
                break;
        }
    }
}
