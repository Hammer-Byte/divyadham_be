<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\District;

class State extends Model
{
    protected $table = 'states';

    protected $fillable = [
        'name',
        'code'
    ];

    public function getDistricts() {
        return $this->hasMany(District::class, 'state_id','id');
    }

}
