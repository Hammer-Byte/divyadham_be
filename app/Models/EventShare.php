<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventShare extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'event_shares';

    protected $fillable = [
        'event_id',
        'user_id',
    ];
}
