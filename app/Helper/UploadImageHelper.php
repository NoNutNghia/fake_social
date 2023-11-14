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

    static public function uploadAvatar($imageFile, $userID)
    {
        $path = "public/avatar/";

        if (Storage::putFileAs($path, $imageFile, $userID . '.' . $imageFile->getClientOriginalExtension())) {
            return $path . $userID . '.' . $imageFile->getClientOriginalExtension();
        }

        return false;
    }

    static public function uploadCoverImage($imageFile, $userID)
    {
        $path = "public/cover_image/";

        if (Storage::putFileAs($path, $imageFile, $userID . '.' . $imageFile->getClientOriginalExtension())) {
            return $path . $userID . '.' . $imageFile->getClientOriginalExtension();
        }

        return false;
    }

    static public function deleteImage($oldPath) {
        return Storage::delete($oldPath);
    }
}
