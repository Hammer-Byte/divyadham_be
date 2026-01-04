<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Donations extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'donations';

    protected $fillable = [
        'dc_id',
        'user_id',
        'amount',
        'currency',
        'donation_date',
        'message',
        'receipt_url',
    ];
}
