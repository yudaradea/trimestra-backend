<?php

namespace App\MediaLibrary;

use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CustomPathGenerator implements PathGenerator
{
    public function getPath(Media $media): string
    {
        // Folder utama untuk original file
        return $media->collection_name . '/' . $media->model_id . '/';
    }

    public function getPathForConversions(Media $media): string
    {
        // Folder untuk file hasil konversi (misalnya thumbnail)
        return $media->collection_name . '/' . $media->model_id . '/conversions/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        // Folder untuk responsive images
        return $media->collection_name . '/' . $media->model_id . '/responsive/';
    }
}
