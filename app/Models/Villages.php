<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\VillageMember;
use App\Models\VillageMedia;
use App\Models\State;
use App\Models\District;
use App\Models\Taluka;

class Villages extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'villages';

    protected $fillable = [
        'name',
        'description',
        'state',
        'district',
        'taluka_id',
        'population',
        'latitude',
        'longitude',
        'status',
    ];

    public function getVillageMembers() {
        return $this->hasMany(VillageMember::class, 'village_id','id')->where('status', 1);
    }

    public function getVillageMedia() {
        return $this->hasMany(VillageMedia::class, 'village_id','id')->where('status', 1);
    }

    public function getState() {
        return $this->hasOne(State::class, 'id','state');
    }

    public function getDistrict() {
        return $this->hasOne(District::class, 'id','district');
    }

    /**
     * Get the taluka (optional - may be null for existing villages).
     */
    public function getTaluka()
    {
        return $this->belongsTo(Taluka::class, 'taluka_id', 'id');
    }
}
