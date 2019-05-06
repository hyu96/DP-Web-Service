<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Disability;
use App\Models\UserDisability;
use App\Models\Need;
use App\Models\Role;
use App\Models\UserNeed;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Exception;

class UsersImport implements OnEachRow
{
    public function onRow(Row $row)
    {   
        $rowIndex = $row->getIndex();
        if ($rowIndex < 2) {
            return;
        }

        $messages = [
            'required' => ':attribute không được trống.',
            'string' => ':attribute phải là chuỗi kí tự',
            'email' => 'Địa chỉ email không hợp lệ',
            'unique' => ':attribute đã được sử dụng',
            'integer' => ':attribute phải là số',
            'size' => ':attribute phải có :size kí tự',
            'min' => ':attribute ít nhất phải có :min kí tự',
            'regex' => ':attribute phải là chuỗi chữ số'
        ];

        $row = $row->toArray();
        $request = request()->all();
        $district_id = $request['district_id'];
        $subdistrict_id = $request['subdistrict_id'];

        $userData = [
            'name' => $row[1],
            'birthday' => $row[2] ? Carbon::parse($row[2]) : $row[2],
            'gender' => $row[3] === 'nam' ? 'male' : 'female',
            'email' => $row[4],
            'identity_card' => (string)$row[5],
            'disability' => $this->getUserDisabilityId($row[6]),
            'disability_detail' => $row[7],
            'academic_level' => $row[8],
            'specialize' => $row[9],
            'address' => $row[10],
            'phone' => (string)intval($row[11]),
            'labor_ability' => $row[12] === null ? 0 : 1,
            'employment_status' => $row[13] ? $row[13] : null,
            'income' => $this->getIncome($row[14]),
            'district_id' => $district_id,
            'subdistrict_id' => $subdistrict_id,
            'created_at' => now(),
            'updated_at' => now()
        ];

        $validator = Validator::make($userData, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'identity_card' => ['required', 'size:9', 'regex:/^([0-9]+)$/'],
            'phone' => ['required', 'string', 'regex:/^([0-9]+)$/'],
            'birthday' => ['required'],
            'gender' => ['required', Rule::in(['male', 'female'])],
            'address' => ['required', 'string'],
            'labor_ability' => ['required', 'boolean'],
            'academic_level' => ['required'],
            'disability' => ['required', 'integer'],
            'disability_detail' => ['required', 'string'],
            'district_id' => ['required', 'integer'],
            'subdistrict_id' => ['required', 'integer']
        ], $messages);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $errors->add('index', $rowIndex);
            throw new Exception($errors);
        }

        $userData['disability_id'] = $userData['disability'];
        $user = User::where('email', $row[4])->first();
        if (is_null($user)) {
            $user = User::create($userData);
        } else {
            $user->update($userData);
        }

        $dataUserNeed = [];
        for ($i = 15; $i <= 21; $i++) {
            $userNeed = $row[$i];
            if ($userNeed !== null) {
                switch ($i) {
                    case 15:
                        $needId = 1;
                        $detail = null;                 
                        break;
                    
                    case 16:
                        $needId = 2;
                        $detail = null;                 
                        break;
                    
                    case 17:
                        $needId = 3;
                        $detail = $row['19'];                 
                        break;

                    case 18:
                        $needId = 4;
                        $detail = null;                 
                        break;

                    case 19:
                        $needId = 5;
                        $detail = null;                 
                        break;

                    case 20:
                        $needId = 6;
                        $detail = null;                 
                        break;

                    case 21:
                        $needId = 7;
                        $detail = null;                 
                        break;
                    
                    default:
                        break;
                }

                $dataUserNeed[] = [
                    'user_id' => $user->id,
                    'need_id' => $needId,
                    'detail' => $detail,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ];
            }
        }
        
        UserNeed::insert($dataUserNeed);
    }

    private function getIncome($data)
    {
        if ($data === null) {
            return null;
        } elseif ($data === 'không có') {
            return 0;
        } else {
            $data = str_replace('.', '',$data);
            $data = str_replace(' vnđ', '', $data);
            return intval($data);
        }
    }

    private function getUserDisabilityId($data)
    {
        $data = strtolower($data);
        $disability = Disability::where('name', $data)->first();
        if ($disability !== null) {
            return $disability->id;
        } else {
            return 6;
        }
    }

    public function chunkSize(): int
    {
        return 100;
    }
}
