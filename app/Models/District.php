<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\State;
use App\Models\Taluka;

class District extends Model
{
    protected $table = 'districts';

    protected $fillable = [
        'name',
        'state_id',
    ];

    public function getState()
    {
        return $this->hasOne(State::class, 'state_id', 'id');
    }

    /**
     * Get the talukas for the district.
     */
    public function getTalukas()
    {
        return $this->hasMany(Taluka::class, 'district_id', 'id');
    }
}
