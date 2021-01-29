<?php

namespace App\Exports\Catalog;

use App\Entity\Catalog\Model\Mark\Detail;
use App\Model\Catalog\Command\Export\ExportDetailsCommand;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class DetailsExport implements FromCollection, WithMapping, WithHeadings, WithColumnFormatting, ShouldAutoSize
{
    /**
     * @var ExportDetailsCommand
     */
    private ExportDetailsCommand $command;

    public function __construct(ExportDetailsCommand $command)
    {
        $this->command = $command;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Detail::with('group')->whereHas('group', function(Builder $q) {
            return $q->where('mark_id', $this->command->getMarkId());
        })->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Name RU',
            'Name EN',
            'Description',
            'Cat.number',
            'Quantity',
            'Use count',
            'Weight',
            'Price',
            'Status',
            'Visible',
            'Group',
        ];
    }

    public function columnFormats(): array
    {
        return [
            //'B' => NumberFormat::FORMAT_DATE_DATETIME,
            'L' => NumberFormat::FORMAT_DATE_DATETIME,
        ];
    }
}
