<?php

declare(strict_types=1);

namespace App\Service\Catalog\Watermark;

interface Watermark
{
    public function process(string $path, string $savePath): void;
}
