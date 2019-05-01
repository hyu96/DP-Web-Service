<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Need extends Model
{
    protected $table = 'needs';

    const CHAM_SOC_Y_TE = 1;
    const HOC_VAN_HOA = 2;
    const HOC_NGHE = 3;
    const HO_TRO_SINH_KE = 4;
    const PHO_BIEN_THONG_TIN = 5;
    const HO_TRO_CHINH_SACH = 6;
}
