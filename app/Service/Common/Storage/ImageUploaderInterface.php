<?php

declare(strict_types=1);

namespace App\Service\Common\Storage;

use Illuminate\Http\UploadedFile;

interface ImageUploaderInterface
{
    public function upload(UploadedFile $file, string $path);
    public function save(string $file, string $path);
}
