<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommitteeMeeting extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'committee_meetings';

    protected $fillable = [
        'committee_id',
        'meeting_date',
        'agenda',
        'minutes',
        'status',
    ];
}
