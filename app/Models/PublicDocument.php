<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PublicDocument extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'public_documents';

    protected $fillable = [
        'title',
        'description',
        'document_upload_type',
        'document_url',
        'uploaded_by',
        'uploaded_date',
        'status',
    ];

    protected $appends = ['document_full_url'];

    public function getdocumentFullUrlAttribute()
    {
        if (!$this->document_url) {
            return null;
        }

        return $this->document_upload_type == 'file_upload' ? getFileUrl($this->document_url) : $this->document_url;
    }
}
