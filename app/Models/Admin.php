<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Authenticatable
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'admins';

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'profile_image',
        'admin_type',
        'status',
    ];
}
