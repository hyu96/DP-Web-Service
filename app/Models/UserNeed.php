<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserNeed extends Model
{
    protected $table = 'user_need';

    protected $fillable = [
        'user_id', 'need_id', 'detail', 'created_at', 'updated_at'
    ];

    public function need()
    {
    	return $this->belongsTo('App\Models\Need');
    }
}
