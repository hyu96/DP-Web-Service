<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $table = 'admins';

    const CITY_ADMIN = 0;
    const DISTRICT_ADMIN = 1;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'identity_card', 'birthday', 'gender', 'district_id', 'role', 'api_token', 'image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token'
    ];

    public function district()
    {
        return $this->belongsTo('App\Models\District', 'district_id');
    }
}
