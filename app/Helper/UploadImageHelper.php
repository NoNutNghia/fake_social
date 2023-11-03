<?php

namespace App\Helper;

use Illuminate\Support\Facades\Storage;

class UploadImageHelper
{
    static public function uploadImage($imageFile, $post_id, $sortIndex)
    {
        $path = "public/post/" . $post_id . "/images/";
        if (Storage::putFileAs($path, $imageFile, $sortIndex . '.' . $imageFile->getClientOriginalExtension())) {
            return $path . $sortIndex . '.' . $imageFile->getClientOriginalExtension();
        }

        return false;
    }
}
