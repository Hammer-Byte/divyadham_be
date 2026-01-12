<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\PostLike;
use App\Models\PostComment;
use App\Models\DonationCampaign;

class Post extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'posts';

    protected $fillable = [
        'user_id',
        'type',
        'content',
        'media_upload_type',
        'media_url',
        'media_type',
        'link_url',
        'link_title',
        'link_description',
        'link_image_url',
        'donation_id',
        'status',
    ];

    protected $casts = [
        'media_url' => 'array',
    ];

    protected $appends = ['media_full_url'];

    public function getmediaFullUrlAttribute()
    {
        if (!$this->media_url) {
            return null;
        }

        if ($this->media_upload_type == 'file_upload') {
            $media_urls = [];
            $mediaData = $this->media_url;
            
            // Handle case where cast might not have worked or data is raw string
            if (is_string($mediaData)) {
                $mediaData = json_decode($mediaData, true);
            }
            
            if (is_array($mediaData)) {
                foreach ($mediaData as $key => $value) {
                    array_push($media_urls, getFileUrl($value));
                }
            }
            return $media_urls;
        }else {
            return $this->media_url;
        }
    }

    public function getUser() {
        return $this->hasOne(User::class, 'id','user_id');
    }

    public function getPostLikes() {
        return $this->hasMany(PostLike::class, 'post_id','id')->with('getUser');
    }

    public function getPostComments() {
        return $this->hasMany(PostComment::class, 'post_id','id')->with('getUser');
    }

    public function getDonation() {
        return $this->hasOne(DonationCampaign::class, 'id','donation_id');
    }
}
