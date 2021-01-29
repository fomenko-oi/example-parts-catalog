<?php

declare(strict_types=1);

namespace App\Model\Catalog\Command\Export;

use App\Exports\Catalog\DetailsExport;
use App\Model\Catalog\Category\Repository\DetailRepository;
use App\Model\Catalog\Category\Repository\MarkRepository;
use Maatwebsite\Excel\Facades\Excel;

class ExportDetailsHandler
{
    /**
     * @var DetailRepository
     */
    private DetailRepository $details;
    /**
     * @var MarkRepository
     */
    private MarkRepository $marks;

    public function __construct(DetailRepository $details, MarkRepository $marks)
    {
        $this->details = $details;
        $this->marks = $marks;
    }

    public function execute(ExportDetailsCommand $command)
    {
        $mark = $this->marks->getById($command->getMarkId());

        return Excel::download(new DetailsExport($command), "details_#{$mark->id}_{$mark->name}_{$mark->model->name}.xlsx");
        /*return Excel::download(new DetailsExport($command), 'details.csv', \Maatwebsite\Excel\Excel::CSV, [
            'Content-Type' => 'text/csv',
        ]);*/
    }
}
