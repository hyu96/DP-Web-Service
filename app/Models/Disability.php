<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disability extends Model
{
    protected $table = 'disabilities';

    protected $fillable = [
        'name'
    ];
}
