<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class EventRegistration extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $guarded = [];
    protected $table = 'event_registration';

    public function getUser() {
        return $this->hasOne(User::class, 'id','user_id');
    }
}
