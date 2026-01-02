<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class PostComment extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $guarded = [];
    protected $table = 'post_comments';

    public function getUser() {
        return $this->hasOne(User::class, 'id','user_id');
    }
}
