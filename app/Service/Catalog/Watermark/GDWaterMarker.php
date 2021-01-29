<?php

declare(strict_types=1);

namespace App\Service\Catalog\Watermark;

use Image;

class GDWaterMarker implements Watermark
{
    private $width;
    private $height;
    private $watermark;

    private $position = 'bottom-left';
    private $x = 5;
    private $y = 5;

    public function __construct($watermark, $width = null, $height = null)
    {
        $this->watermark = $watermark;
        $this->width = $width;
        $this->height = $height;
    }

    public function setPosition($x, $y, $position = 'bottom-left'): void
    {
        $this->x = $x;
        $this->y = $y;
        $this->position = $position;
    }

    public function process(string $path, string $savePath): void
    {
        $image = Image::make($path);

        $imageWatermark = Image::make($this->watermark);
        $imageWatermark->resize($this->width, $this->height);

        $image->insert($imageWatermark, $this->position, $this->x, $this->y);
        $image->save($savePath);
    }
}
