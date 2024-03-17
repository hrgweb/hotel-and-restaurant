<?php

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

if (!function_exists('img_optimizer')) {
    function img_optimzer(UploadedFile $file, string $pathToSave, int $width = 96, int $height = 96): void
    {
        // create image manager with desired driver
        $manager = new ImageManager(new Driver());

        // read image from file system
        $image = $manager->read($file);

        // resize image proportionally to 300px width
        $image->scale(width: $width, height: $height);

        // save modified image in new format
        $image->toPng()->save($pathToSave);
    }
}

if (!function_exists('img_filename')) {
    function img_filename(Request $request, string $name = 'image'): string
    {
        // Get just the file extension
        $extension = $request->file($name)->getClientOriginalExtension();

        // Generate a unique file name
        $fileNameToStore = time() . '.' . $extension;

        return $fileNameToStore;
    }
}
