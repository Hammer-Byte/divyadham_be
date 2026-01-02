<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pages extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'pages';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'status',
    ];
}
