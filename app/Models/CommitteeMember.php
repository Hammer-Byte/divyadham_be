<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class CommitteeMember extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'committee_members';

    protected $fillable = [
        'committee_id',
        'user_id',
        'role',
        'status',
    ];

    public function getUser() {
        return $this->hasOne(User::class, 'id','user_id')->where('status', 1);
    }
}
