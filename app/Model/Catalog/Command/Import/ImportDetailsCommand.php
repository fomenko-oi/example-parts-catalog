<?php

declare(strict_types=1);

namespace App\Model\Catalog\Command\Import;

use Illuminate\Http\UploadedFile;
use Webmozart\Assert\Assert;

class ImportDetailsCommand
{
    private int $markId;
    private string $path;

    public function __construct(int $markId, string $path)
    {
        $this->markId = $markId;
        $this->path = $path;
    }

    /**
     * @return int
     */
    public function getMarkId(): int
    {
        return $this->markId;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }
}
