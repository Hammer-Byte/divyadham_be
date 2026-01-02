<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PublicGalleryMedia extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'public_gallery_media';

    protected $fillable = [
        'folder_id',
        'title',
        'description',
        'media_upload_type',
        'media_url',
        'media_type',
        'position',
        'uploaded_by',
        'uploaded_date',
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
