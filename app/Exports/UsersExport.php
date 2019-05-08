<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class UsersExport implements FromView
{
    protected $district_id;
    protected $subdistrict_id;

    public function __construct($district_id, $subdistrict_id)
    {
        $this->district_id = $district_id;
        $this->subdistrict_id = $subdistrict_id;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $users = User::where([
            'district_id' => $this->district_id,
            'subdistrict_id' => $this->subdistrict_id
        ])->with(['disability', 'needs.need'])->get();

        return view('user.export-template', [
            'users' => $users
        ]);
    }
}
