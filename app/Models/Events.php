<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Events extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'events';

    protected $fillable = [
        'title',
        'description',
        'banner_upload_type',
        'banner_image_url',
        'event_image_upload_type',
        'event_image_url',
        'start_date',
        'end_date',
        'location',
        'latitude',
        'longitude',
        'organizers',
        'status',
    ];

    public function getEventMedia() {
        return $this->hasMany(EventMedia::class, 'event_id','id')->where('status', 1);
    }

    protected $appends = ['banner_image_full_url', 'event_image_full_url'];

    public function getbannerImageFullUrlAttribute()
    {
        if (!$this->banner_image_url) {
            return null;
        }

        return $this->banner_upload_type == 'file_upload' ? getFileUrl($this->banner_image_url) : $this->banner_image_url;
    }

    public function geteventImageFullUrlAttribute()
    {
        if (!$this->event_image_url) {
            return null;
        }

        return $this->event_image_upload_type == 'file_upload' ? getFileUrl($this->event_image_url) : $this->event_image_url;
    }
}
