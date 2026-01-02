<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\CommitteeMember;
use App\Models\CommitteeMeeting;
use App\Models\CommitteeFinance;

class Committee extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'committees';

    protected $fillable = [
        'name',
        'description',
        'formed_date',
        'status',
    ];

    public function getCommitteeMembers() {
        return $this->hasMany(CommitteeMember::class, 'committee_id','id')->where('status', 1);
    }

    public function getCommitteeMeetings() {
        return $this->hasMany(CommitteeMeeting::class, 'committee_id','id')->where('status', 1);
    }

    public function getCommitteeFinance() {
        return $this->hasMany(CommitteeFinance::class, 'committee_id','id');
    }
}
