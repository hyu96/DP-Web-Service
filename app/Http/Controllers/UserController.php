<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Disability;
use App\Models\UserDisability;
use App\Models\Need;
use App\Models\Role;
use App\Models\UserNeed;
use App\Models\District;
use App\Models\Subdistrict;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('user.list');
    }

    public function show(Request $request, $id)
    {
        $district = District::find(Auth::user()->district_id);
        $disabilities = Disability::all()->pluck('name', 'id');
        $needs = Need::all();
        return view('user.show')->with([
            'id' => $id,
            'district' => $district,
            'disabilities' => $disabilities,
            'needs' => $needs
        ]);
    }

    public function create()
    {
        $district = District::find(Auth::user()->district_id);
        $disabilities = Disability::all()->pluck('name', 'id');
        $needs = Need::all();
        return view('user.create')->with([
            'district' => $district,
            'disabilities' => $disabilities,
            'needs' => $needs
        ]);
    }

    public function showUserImport()
    {
        $addressData = $this->getAddressByRole();
        $isSuperadministrator = $this->checkIsSuperAdmin();
        return view('admin.user.import')->with([
            'districts' => $addressData['districts'],
            'subdistricts' => $addressData['subdistricts'],
            'isSuperadministrator' => $isSuperadministrator,
        ]);
    }

    public function importUser(Request $request)
    {
        try {
            $import = Excel::import(new UsersImport, request()->file('user_file'));
            return redirect()->route('admin.users.index');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
        }
    }

    public function showUserExport()
    {
        $addressData = $this->getAddressByRole();
        $isSuperadministrator = $this->checkIsSuperAdmin();
        return view('admin.user.export')->with([
            'districts' => $addressData['districts'],
            'subdistricts' => $addressData['subdistricts'],
            'isSuperadministrator' => $isSuperadministrator,
        ]);
    }

    public function exportUser(Request $request)
    {
        try {
            return Excel::download(new UsersExport($request->district_id, $request->subdistrict_id), 'users.xlsx');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
        }
    }

    protected function editValidator(array $data, $id)
    {
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

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'. $id],
            'identity_card' => ['required', 'string', 'size:9', 'regex:/^([0-9]+)$/'],
            'phone' => ['required', 'string', 'min:10', 'regex:/^([0-9]+)$/'],
            'birthday' => ['required', 'string'],
            'gender' => ['required', Rule::in(['male', 'female'])],
            'address' => ['required', 'string'],
            'labor_ability' => ['required', 'boolean'],
            'income' => ['integer'],
            'academic_level' => ['required'],
            'disability' => ['required', 'integer'],
            'disability_detail' => ['required', 'string'],
            'need' => ['required'],
            'district_id' => ['required', 'integer'],
            'subdistrict_id' => ['required', 'integer']
        ], $messages);
    }

    public function edit(Request $request, $id) {
        $data = $request->all();
        $this->editValidator($data, $id)->validate();
        $user = User::find($id);
        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'identity_card' => $data['identity_card'],
            'birthday' => $data['birthday'],
            'gender' => $data['gender'],
            'address' => $data['address'],
            'employment_status' => $data['employment_status'],
            'labor_ability' => $data['labor_ability'],
            'income' => $data['income'],
            'academic_level' => $data['academic_level'],
            'specialize' => $data['specialize'],
            'status' => $user->status,
            'district_id' => $data['district_id'],
            'subdistrict_id' => $data['subdistrict_id'],
            'approver_id' => $user->approver_id,
            'admin_update_id' => Auth::guard('admin')->user()->id,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $userDisability = UserDisability::where('user_id', $id)->first();
        $userDisability->update([
            'disability_id' => $data['disability'],
            'detail' => $data['disability_detail'],
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        $requestUserNeedIds = $data['need'];
        $userNeedIds = UserNeed::where('user_id', $id)->get()->pluck('need_id')->toArray();
        $deletedIds = array_diff($userNeedIds, $requestUserNeedIds);
        foreach($requestUserNeedIds as $needId) {
            $userNeed = UserNeed::where(['user_id' => $id, 'need_id' => $needId])->first();
            if (empty($userNeed)) {
                UserNeed::create([
                    'user_id' => $user->id,
                    'need_id' => $needId,
                    'detail' => $this->getNeedDetail($needId, $data),
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ]);
            } else {
                $userNeed->update([
                    'detail' => $this->getNeedDetail($needId, $data),
                    'updated_at' => date("Y-m-d H:i:s")
                ]);
            }
        }
        foreach ($deletedIds as $deletedId) {
            UserNeed::where(['user_id' => $id, 'need_id' => $deletedId])->first()->delete();
        }
        return redirect()->back()->with('success', 'Chỉnh sửa thành công');
    }
}
