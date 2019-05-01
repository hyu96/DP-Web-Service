<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disability extends Model
{
    protected $table = 'disabilities';

    public function disability()
    {
    	return $this->belongsTo('App\Models\Disability');
    }
}
