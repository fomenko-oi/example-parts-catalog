<?php

declare(strict_types=1);

namespace App\Service\Common\Storage;

use App\Service\Catalog\Watermark\Watermark;
use Illuminate\Http\UploadedFile;
use Storage;

class ImageUploader implements ImageUploaderInterface
{
    /**
     * @var Watermark
     */
    private Watermark $watermark;

    public function __construct(Watermark $watermark)
    {
        $this->watermark = $watermark;
    }

    public function upload(UploadedFile $file, string $path, ?string $name = null)
    {
        if (!$name) {
            $name = $file->getClientOriginalName() . '.' . $file->getExtension();
        }

        $src = $file->storePubliclyAs($path, $name, ['disk' => 'public']);
        $srcPath = storage_path("app/public/{$src}");

        try {
            $this->watermark->process($srcPath, $srcPath);
        } catch (\Exception $e) {

        }

        return "{$path}/{$name}";
    }

    public function save(string $file, string $path, ?string $name = null)
    {
        if (!$name) {
            $name = basename($file);
        }

        Storage::disk('public')->put(
            "{$path}/{$name}",
            file_get_contents($file)
        );

        return "{$path}/{$name}";
    }
}
