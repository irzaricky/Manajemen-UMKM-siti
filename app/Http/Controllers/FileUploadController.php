<?php

namespace App\Http\Controllers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadController
{
    public function uploadFile(UploadedFile $file, string $path): string
    {
        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        $file->storeAs("/$path", $filename);
        return "$path/$filename";
    }

    public function deleteFile(?string $path): void
    {
        if ($path && Storage::exists("/$path")) {
            Storage::delete("/$path");
        }
    }
}