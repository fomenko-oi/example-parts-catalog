<?php

declare(strict_types=1);

namespace App\Model\Catalog\Command\SearchDetail;

use App\Model\Catalog\Category\Repository\DetailRepository;
use App\Model\Catalog\Dto\Detail\SearchDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class SearchDetailHandler
{
    /**
     * @var DetailRepository
     */
    private DetailRepository $details;

    public function __construct(DetailRepository $details)
    {
        $this->details = $details;
    }

    public function execute(SearchDetailCommand $command, $limit = 30): LengthAwarePaginator
    {
        $query = new SearchDto();
        $query->sku = $command->getQuery();

        $items = $this->details->search($query, $limit);

        return $items;
    }
}
