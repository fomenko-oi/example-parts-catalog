<?php

declare(strict_types=1);

namespace App\Service\Catalog\Watermark;

use Image;
use Intervention\Image\Gd\Font;

class TextWaterMarker implements Watermark
{
    private string $text;
    private int $fontSize;
    private int $x;
    private int $y;

    public function __construct(string $text, int $fontSize = 100, int $x = 0, $y = 0)
    {
        $this->text = $text;
        $this->fontSize = $fontSize;
        $this->x = $x;
        $this->y = $y;
    }

    public function process(string $path, string $savePath): void
    {
        $image = Image::make($path);

        $font = new Font($this->text);
        $this->setFont($font);

        if ($font->getBoxSize()['width'] > $image->getWidth()) {
            $this->fontSize -= (int)ceil($image->getWidth() / ($font->getBoxSize()['width'] - $image->getWidth() + $this->x));
        }

        $image->text($this->text, $this->x, $image->height() - $this->y, function(Font $font) {
            $this->setFont($font);
        });

        $image->save($savePath);
    }

    protected function setFont(Font &$font)
    {
        $font->file(public_path('fonts/system/Varta-Bold.ttf'));
        $font->size($this->fontSize);
        $font->color('#e1e1e1');
        $font->color('#e0e0e0');
        $font->color([224, 224, 224, .5]);
        $font->align('left');
        $font->valign('center');
        $font->angle(45);

        return $font;
    }
}
