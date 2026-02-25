<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class FamilyMember extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $guarded = [];
    protected $table = 'family_members';

    public function getUser() {
        return $this->hasOne(User::class, 'id','added_by');
    }

    public function getFamilyMemberUser() {
        return $this->hasOne(User::class, 'id','user_id');
    }

    /**
     * Get the full name of the family member
     * Returns name from User table if registered, otherwise from family_members table
     */
    public function getFullNameAttribute()
    {
        if ($this->user_id) {
            $user = $this->getFamilyMemberUser;
            if ($user) {
                return trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''));
            }
        }
        return trim(($this->first_name ?? '') . ' ' . ($this->last_name ?? ''));
    }

    /**
     * Get the phone number of the family member for display
     * Returns phone from User table if registered, otherwise from family_members table
     */
    public function getDisplayPhoneNumberAttribute()
    {
        if ($this->user_id) {
            $user = $this->getFamilyMemberUser;
            if ($user) {
                return $user->phone_number ?? $this->attributes['phone_number'] ?? null;
            }
        }
        return $this->attributes['phone_number'] ?? null;
    }

    /**
     * Check if family member is registered user
     */
    public function isRegistered()
    {
        return !is_null($this->user_id);
    }
}
