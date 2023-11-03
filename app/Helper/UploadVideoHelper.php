<?php

namespace App\Helper;

use Illuminate\Support\Facades\Storage;

class UploadVideoHelper
{
    static public function uploadVideo($file, $post_id, $sortIndex)
    {
        $path = "public/post/" . $post_id . "/videos/";
        if (Storage::putFileAs($path, $file, $sortIndex . '.' .  $file->getClientOriginalExtension())) {
            return $path . $sortIndex . '.' . $file->getClientOriginalExtension();
        }

        return false;
    }
}
