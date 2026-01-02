<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\State;

class District extends Model
{
    protected $table = 'districts';

    protected $fillable = [
        'name',
        'state_id',
    ];

    public function getState() {
        return $this->hasOne(State::class, 'state_id','id');
    }
}
