<?php

namespace App\Traits;


use App\Models\Setting;
use Intervention\Image\Facades\Image;

trait GeneralTrait
{
    public function uploadImage($folder, $image)
    {
        $filename = $image->hashName();
        $path = 'backend/images/' . $folder . '/' . $filename;
        Image::make($image)->resize(300, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path($path));
        return $path;
    }

    public function routeToken()
    {
        $setting = Setting::first();
        return $setting->route_token;
    }
}
