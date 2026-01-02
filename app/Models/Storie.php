<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Storie extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $guarded = [];
    protected $table = 'stories';

    public function getUser() {
        return $this->hasOne(User::class, 'id','user_id');
    }

    protected $appends = ['media_full_url'];

    public function getmediaFullUrlAttribute()
    {
        if (!$this->media_url) {
            return null;
        }

        return getFileUrl($this->media_url);
    }
}
