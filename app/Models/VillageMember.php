<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class VillageMember extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'village_members';

    protected $fillable = [
        'village_id',
        'user_id',
        'status',
    ];

    public function getUser() {
        return $this->hasOne(User::class, 'id','user_id')->where('status', 1);
    }
}
