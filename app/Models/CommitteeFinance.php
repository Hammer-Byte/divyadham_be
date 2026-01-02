<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommitteeFinance extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'committee_finances';

    protected $fillable = [
        'committee_id',
        'transaction_date',
        'amount',
        'transaction_type',
        'description',
        'remark',
    ];
}
