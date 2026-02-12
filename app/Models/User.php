<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'country_code',
        'phone_number',
        'first_name',
        'last_name',
        'profile_image',
        'is_verified',
        'email',
        'occupation',
        'campany_name',
        'address',
        'city',
        'state',
        'district',
        'village',
        'country',
        'zipcode',
        'status',
        'device_type',
        'device_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    public function scopeWithoutSystemAdmin($query)
    {
        return $query->where('id','!=',config('common.system_admin_and_user_id'));
    }

    protected $appends = ['profile_image_url'];

    public function getProfileImageUrlAttribute()
    {
        if (!$this->profile_image) {
            return null;
        }

        return getFileUrl($this->profile_image);
    }
}
