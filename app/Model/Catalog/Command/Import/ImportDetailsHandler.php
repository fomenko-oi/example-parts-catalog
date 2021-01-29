<?php

declare(strict_types=1);

namespace App\Model\Catalog\Command\Import;

use App\Imports\Catalog\DetailsImport;
use App\Model\Catalog\Category\Repository\DetailRepository;
use Maatwebsite\Excel\Facades\Excel;

class ImportDetailsHandler
{
    /**
     * @var DetailRepository
     */
    private DetailRepository $details;

    public function __construct(DetailRepository $details)
    {
        $this->details = $details;
    }

    public function execute(ImportDetailsCommand $command)
    {
        Excel::import(new DetailsImport($command), $command->getPath());
    }
}
