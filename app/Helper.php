<?php

namespace App;

use Intervention\Image\Facades\Image;

class Helper
{
    public static function uploadBase64Avatar($base64 = '', Restaurant $restaurant = null)
    {
//        var_dump('In here');
        if (empty($base64)) {
            return empty($restaurant->avatar) ? 'default.jpg' : $restaurant->avatar;
        }

        try {
            $image = Image::make($base64)->resize(300, 300);
        } catch (\Exception $e) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'avatar' => ['Image invalide'],
            ]);
            throw $error;
        }

        if ($image->filesize() <= 2000) {
            $mimes = new \Mimey\MimeTypes;

            if (!empty($restaurant)) {
                $basename = str_slug($restaurant->name) . '-' . $restaurant->id;
            } else {
                $tempname = tempnam(public_path('img/avatar/'), 'avatar_');
                $basename = basename($tempname);
                @unlink($tempname);
            }

            $name = $basename . '.' . $mimes->getExtension($image->mime());
            $path = public_path('img/avatar/' . $name);
            $image->save($path);

            return $name;
        } else {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'avatar' => ['Image trop lourde.'],
            ]);
            throw $error;
        }
    }
}
