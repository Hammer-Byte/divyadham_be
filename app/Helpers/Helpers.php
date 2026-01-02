<?php

use Illuminate\Support\Facades\Storage;

/**
 * Store a file (Common function for Local & S3)
 *
 * @param  \Illuminate\Http\UploadedFile|null  $file
 * @param  string  $path
 * @param  string  $disk ('public' for local, 's3' for AWS)
 * @return string|null
 */
function storeFile($file, $path = 'uploads', $disk = 'public')
{
    return $file ? $file->store($path, $disk) : null;
}

/**
 * Get file URL (Common function for Local & S3)
 *
 * @param  string|null  $filePath
 * @param  string  $disk ('public' for local, 's3' for AWS)
 * @return string
 */
function getFileUrl($filePath, $disk = 'public')
{
    if (!$filePath) {
        return asset('assets/images/default-profile.png'); // Default image
    }

    return $disk === 's3' ? Storage::disk('s3')->url($filePath) : asset("storage/$filePath");
}
