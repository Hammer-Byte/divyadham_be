<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostShare extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'post_shares';

    protected $fillable = [
        'post_id',
        'user_id',
    ];
}
