<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PublicGalleryFolder extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'public_gallery_folder';

    protected $fillable = [
        'folder_name',
        'description',
        'status',
    ];
}
