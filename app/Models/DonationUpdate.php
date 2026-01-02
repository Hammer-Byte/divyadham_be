<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DonationUpdate extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'donation_updates';

    protected $fillable = [
        'donation_id',
        'title',
        'description',
        'status',
    ];
}
