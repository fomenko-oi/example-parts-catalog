<?php

declare(strict_types=1);

namespace App\Model\Catalog\Command\SuggestSearch;

use App\Model\Catalog\Category\Repository\DetailRepository;
use App\Model\Catalog\Dto\Detail\SearchDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class SuggestSearchHandler
{
    /**
     * @var DetailRepository
     */
    private DetailRepository $details;

    public function __construct(DetailRepository $details)
    {
        $this->details = $details;
    }

    public function execute(SuggestSearchCommand $command): LengthAwarePaginator
    {
        $query = new SearchDto();
        $query->sku = $command->getQuery();

        $items = $this->details->search($query, 10);

        return $items;
    }
}
