<?php

namespace App\Imports\Catalog;

use App\Entity\Catalog\Model\Mark\Detail;
use App\Entity\Catalog\Model\Mark\Group;
use App\Model\Catalog\Category\Repository\DetailRepository;
use App\Model\Catalog\Category\Repository\GroupRepository;
use App\Model\Catalog\Category\UseCase\DetailService;
use App\Model\Catalog\Command\Import\ImportDetailsCommand;
use App\Model\Catalog\Entity\Detail\Name;
use App\Model\Catalog\Entity\Detail\Price;
use App\Model\Catalog\Entity\Detail\Quantity;
use App\Model\Catalog\Entity\Detail\Status;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Row;
use Illuminate\Validation\Rule;
use App\Model\Catalog\Entity\Detail\Detail as DetailItem;

class DetailsImport implements /*ToModel, */WithHeadingRow, WithValidation, OnEachRow, WithChunkReading
{
    /**
     * @var ImportDetailsCommand
     */
    private ImportDetailsCommand $command;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    /*public function model(array $row)
    {
        dd($row);

        return new Detail([
            ''
        ]);
    }*/

    public function __construct(ImportDetailsCommand $command)
    {
        $this->command = $command;
    }

    public function rules(): array
    {
        return [
            'status' => Rule::in(array_keys(Detail::getStatusesList()))
        ];
    }

    public function onRow(Row $row)
    {
        $detailService = app(DetailService::class);

        $item = $row->toArray();

        // TODO mb change getById to findById and create new detail id it's not exists
        /** @var Detail $detail */
        $detail = Detail::where('id', $item['id'])->with('group')->firstOrFail();

        $group = $detail->group;

        if ($group->name !== $item['group']) {
            $group = Group::firstOrCreate(['name' => $item['group'], 'mark_id' => $group->mark_id]);
        }

        $detailItem = new DetailItem(
            new Name($item['name'], $item['catnumber'], $item['name_ru'], $item['name_en'], $item['description']),
            new Quantity((int)$item['quantity'], $item['use_count'], $item['weight']),
            new Status($item['status']),
            new Price($item['price']),
            $detail['visible'] === '+',
            $group->id
        );

        $detailService->update($detail, $detailItem);

        unset($detailItem);
    }

    public function chunkSize(): int
    {
        return 100;
    }
}
