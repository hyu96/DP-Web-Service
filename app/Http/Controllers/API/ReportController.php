<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController;
use App\Models\User;
use App\Models\Disability;
use App\Models\Need;
use App\Models\UserNeed;

class ReportController extends BaseController
{
	public function index(Request $request)
	{
		$type = $request->query('type');
		$data = [];
		switch ($type) {
			case 'labor_ability':
				$data = $this->getLaborAbilityReport();
				break;
			
			case 'disability':
				$data = $this->getDisabilityReport();
				break;

			case 'need':
				$data = $this->getNeedReport();
				break;

			case 'gender':
			default:
				$data = $this->getGenderReport();
				break;
		}

		return $this->responseSuccess(200, $data);
	}

	protected function getGenderReport()
	{
		$data = [
			'labels' => ['Nam', 'Nữ'],
			'count' => []
		];
        $data['count'][] = User::where('gender', User::MALE)->get()->count();
        $data['count'][] = User::where('gender', USER::FEMALE)->get()->count();
        return $data;
	}

	protected function getLaborAbilityReport()
	{
		$data = [
			'labels' => ['Còn', 'Không còn'],
			'count' => []
		];
        $data['count'][] = User::where('labor_ability', 1)->get()->count();
        $data['count'][] = User::where('labor_ability', 0)->get()->count();
        return $data;
	}

	protected function getDisabilityReport()
	{
		$data = [];
		$data['labels'] = Disability::all()->pluck('name')->toArray();
		$disabilites = Disability::all()->pluck('name', 'id');
        foreach ($disabilites as $id => $disability) {
			$data['count'][] = User::where('disability_id', $id)->get()->count();
        }
        return $data;
	}

	protected function getNeedReport()
	{
		$data = [];
		$data['labels'] = Need::all()->pluck('detail')->toArray();
		$needs = Need::all()->pluck('detail', 'id');
        foreach ($needs as $id => $need) {
            $data['count'][] = UserNeed::where('need_id', $id)->get()->count();
        }
        return $data;
	}
}
