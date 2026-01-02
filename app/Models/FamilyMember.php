<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class FamilyMember extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $guarded = [];
    protected $table = 'family_members';

    public function getUser() {
        return $this->hasOne(User::class, 'id','added_by');
    }

    public function getFamilyMemberUser() {
        return $this->hasOne(User::class, 'id','user_id');
    }
}
