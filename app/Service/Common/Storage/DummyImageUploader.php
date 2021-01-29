<?php

declare(strict_types=1);

namespace App\Service\Common\Storage;

use Illuminate\Http\UploadedFile;

class DummyImageUploader implements ImageUploaderInterface
{
    public function upload(UploadedFile $file, string $path, ?string $name = null)
    {
        return "{$path}/{$name}";
    }

    public function save(string $file, string $path, ?string $name = null)
    {
        return $file;
    }
}
