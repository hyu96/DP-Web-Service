<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Disability;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\UserDisability;
use App\Models\UserNeed;
use App\Models\Need;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use App\Exports\ReportsExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function all()
    {
        return view('report.all');
    }

    protected function getGenderReport()
    {
        $data = [
            'labels' => ['Nam', 'Nữ'],
            'count' => []
        ];
        $admin = Auth::user();
        if ($admin->role === Admin::CITY_ADMIN) {
            $data['count'][] = User::where('gender', User::MALE)->get()->count();
            $data['count'][] = User::where('gender', User::FEMALE)->get()->count();
        } else {
            $data['count'][] = User::where(['gender' => User::MALE, 'district_id' => $admin->district_id])->get()->count();
            $data['count'][] = User::where(['gender'=> User::FEMALE, 'district_id' => $admin->district_id])->get()->count();
        }
        return $data;
    }

    protected function getLaborAbilityReport()
    {
        $data = [
            'labels' => ['Còn', 'Không còn'],
            'count' => []
        ];
        $admin = Auth::user();
        if ($admin->role === Admin::CITY_ADMIN) {
            $data['count'][] = User::where('labor_ability', 1)->get()->count();
            $data['count'][] = User::where('labor_ability', 0)->get()->count();
        } else {
            $data['count'][] = User::where(['labor_ability' => 1, 'district_id' => $admin->district_id])->get()->count();
            $data['count'][] = User::where(['labor_ability' => 0, 'district_id' => $admin->district_id])->get()->count();
        }
        return $data;
    }

    protected function getDisabilityReport()
    {
        $data = [];
        $data['labels'] = Disability::all()->pluck('name')->toArray();
        $disabilites = Disability::all()->pluck('name', 'id');
        $admin = Auth::user();
        foreach ($disabilites as $id => $disability) {
            if ($admin->role === Admin::CITY_ADMIN) {
                $data['count'][] = User::where('disability_id', $id)->get()->count();
            } else {
                $data['count'][] = User::where(['disability_id' => $id, 'district_id' => $admin->district_id])->get()->count();
            }
        }
        return $data;
    }

    protected function getNeedReport()
    {
        $data = [];
        $data['labels'] = Need::all()->pluck('detail')->toArray();
        $needs = Need::all()->pluck('detail', 'id');
        $admin = Auth::user();
        foreach ($needs as $id => $need) {
            if ($admin->role === Admin::CITY_ADMIN) {
                $data['count'][] = UserNeed::where('need_id', $id)->get()->count();
            } else {
                $data['count'][] = UserNeed::whereHas("user", function($q) use ($admin){
                   $q->where("district_id", $admin->district_id);
                })->where(['need_id' => $id])->get()->count();
            }
        }
        return $data;
    }

    public function export(Request $request)
    {
        $type = $request->query('type');
        $data = [];
        switch ($type) {
            case 'labor_ability':
                $data = $this->getLaborAbilityReport();
                $name = 'Khả năng lao động';
                break;
            
            case 'disability':
                $data = $this->getDisabilityReport();
                $name = 'Dạng tật';
                break;

            case 'need':
                $data = $this->getNeedReport();
                $name = 'Nhu cầu';
                break;

            case 'gender':
            default:
                $data = $this->getGenderReport();
                $name = 'Giới tính';
                break;
        }

        try {
            return Excel::download(new ReportsExport($data), $name .'.xlsx');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
        }
    }
}
