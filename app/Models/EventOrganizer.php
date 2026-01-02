<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
class EventOrganizer extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $guarded = [];
    protected $table = 'event_organizers';

    public function getUser() {
        return $this->hasOne(User::class, 'id','organizer_id');
    }
}
