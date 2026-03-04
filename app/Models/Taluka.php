<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Villages;

class Taluka extends Model
{
    protected $table = 'taluka';

    protected $fillable = [
        'name',
        'district_id',
    ];

    /**
     * Get the district that owns the taluka.
     */
    public function getDistrict()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }

    /**
     * Get the villages in this taluka.
     */
    public function getVillages()
    {
        return $this->hasMany(Villages::class, 'taluka_id', 'id');
    }
}
