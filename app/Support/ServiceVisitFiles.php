<?php

namespace App\Support;

use App\Models\ServicePhoto;
use App\Models\ServiceRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ServiceVisitFiles
{
    public static function store(ServiceRequest $request, UploadedFile $file, string $prefix): string
    {
        $dir = public_path('uploads/services/'.$request->id);
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $extension = strtolower($file->getClientOriginalExtension() ?: $file->guessExtension() ?: 'bin');
        $name = $prefix.'-'.Str::uuid().'.'.$extension;
        $file->move($dir, $name);

        return 'uploads/services/'.$request->id.'/'.$name;
    }

    public static function deletePath(?string $path): void
    {
        if (! $path || ! str_starts_with($path, 'uploads/')) {
            return;
        }

        $full = public_path($path);
        if (is_file($full)) {
            unlink($full);
        }
    }

    public static function deletePhoto(ServicePhoto $photo): void
    {
        self::deletePath($photo->path);
        $photo->delete();
    }
}
