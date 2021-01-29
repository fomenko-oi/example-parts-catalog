<?php

declare(strict_types=1);

namespace App\Service\Catalog\Watermark;

class DummyWaterMarker implements Watermark
{
    private $width;
    private $height;
    private $watermark;

    private $position = 'bottom-left';
    private $x = 5;
    private $y = 5;

    public function __construct($watermark = 'dummy', $width = null, $height = null)
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

    }
}
