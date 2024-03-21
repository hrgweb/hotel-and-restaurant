<?php

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
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

if (!function_exists('old_img_remove')) {
    function old_img_remove(string|null $thumbnail, string $path = 'app/public/uploads/'): void
    {
        if ($thumbnail && File::exists(storage_path($path . $thumbnail))) {
            unlink(storage_path($path . $thumbnail));
        }
    }
}

if (!function_exists('find_or_create_directory')) {
    function find_or_create_directory(string $path = 'app/public/uploads/'): void
    {
        // Specify the directory path
        $directory = storage_path($path);

        // Check if the directory exists
        if (!is_dir($directory)) {
            // Directory doesn't exist, so create it
            if (!mkdir($directory, 0755, true)) {
                // Failed to create directory
                Log::error('failed to create directory');
            }
        }
    }
}

if (!function_exists('generate_reference_no')) {
    function generate_reference_no(string $prefix = 'ORD')
    {
        return $prefix . uniqid();
    }
}
