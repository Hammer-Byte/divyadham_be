<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VillageMedia extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'village_media';

    protected $fillable = [
        'village_id',
        'media_upload_type',
        'media_url',
        'media_type',
        'position',
        'status',
    ];

    protected $appends = ['media_full_url'];

    public function getmediaFullUrlAttribute()
    {
        if (!$this->media_url) {
            return null;
        }

        return $this->media_upload_type == 'file_upload' ? getFileUrl($this->media_url) : $this->media_url;
    }
}
