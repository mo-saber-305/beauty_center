<?php

namespace App\Traits;
trait GeneralTrait
{
    public function uploadImage($folder, $image)
    {
        $filename = $image->hashName();
        $path2 = public_path("backend/images/" . $folder);
        $image->move($path2, $filename);
        $path = 'backend/images/' . $folder . '/' . $filename;
        return $path;
    }
}
