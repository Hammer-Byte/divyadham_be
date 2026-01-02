<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DonationCampaign extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'donation_campaigns';

    protected $fillable = [
        'title',
        'description',
        'donation_type',
        'goal_amount',
        'raise_amount',
        'start_date',
        'end_date',
        'banner_upload_type',
        'banner_image_url',
        'organizers',
        'status',
    ];

    public function getDonationMedia() {
        return $this->hasMany(DonationMedia::class, 'donation_id','id')->where('status', 1);
    }

    public function getDonationUpdates() {
        return $this->hasMany(DonationUpdate::class, 'donation_id','id')->where('status', 1);
    }

    protected $appends = ['banner_image_full_url'];

    public function getbannerImageFullUrlAttribute()
    {
        if (!$this->banner_image_url) {
            return null;
        }

        return $this->banner_upload_type == 'file_upload' ? getFileUrl($this->banner_image_url) : $this->banner_image_url;
    }
}
