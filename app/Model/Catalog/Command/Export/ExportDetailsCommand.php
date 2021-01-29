<?php

declare(strict_types=1);

namespace App\Model\Catalog\Command\Export;

use Webmozart\Assert\Assert;

class ExportDetailsCommand
{
    private $markId;

    public function __construct($markId)
    {
        $this->markId = $markId;
    }

    /**
     * @return mixed
     */
    public function getMarkId()
    {
        return $this->markId;
    }
}
