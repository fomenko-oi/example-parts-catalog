<?php

namespace App\Exports\Delivery;

use App\Model\Delivery\Entity\Delivery\DeliveryMethod;
use App\Model\Delivery\Entity\Delivery\Range;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class PricesExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithColumnFormatting, WithStrictNullComparison
{
    /**
     * @var DeliveryMethod
     */
    private DeliveryMethod $deliveryMethod;
    private int $regionId;

    public function __construct(DeliveryMethod $deliveryMethod, int $regionId)
    {
        $this->deliveryMethod = $deliveryMethod;
        $this->regionId = $regionId;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->deliveryMethod->regions()->where('id', $this->regionId)->firstOrFail()->ranges()->get();
    }

    /**
     * @param Range $row
     * @return array
     */
    public function map($row): array
    {
        //dd($row->toArray());

        return [
            $row->getFromKg(),
            $row->getToKg(),
            //$row->type,
            $row->price,
            //$row->region_id,
        ];
    }

    public function headings(): array
    {
        return [
            'From (kg)',
            'To (kg)',
            //'Type',
            'Price (¥)',
            //'Region ID',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_NUMBER_00,
            'B' => NumberFormat::FORMAT_NUMBER_00,
            'C' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}
