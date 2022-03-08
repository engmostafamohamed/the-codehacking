<?php

namespace App\Http\traits;

use function PHPUnit\Framework\fileExists;

trait media
{

    public function uploadMedia($image, $path)
    {
        $imageName = time() . '.' . $image->extension();
        $image->move(public_path('images//' . $path), $imageName);
        return $imageName;
    }
    public function deleteMedia($oldImageProduct, $path)
    {
        $oldImage = public_path("images//$path//" . $oldImageProduct);
        if( file_exists($oldImage)){
                unlink($oldImage);
        }
    }
}
?>
