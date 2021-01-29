<?php

declare(strict_types=1);

namespace App\Model\Cart\Service\Storage;

use App\Model\Cart\Entity\DetailItem;
use App\Model\Cart\Service\CartItem;
use App\Entity\Catalog\Model\Mark\Detail;

class DbStorage implements StorageInterface
{
    private $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function load(): array
    {
        $rows = DetailItem::with('detail')->whereHas('detail')->where('user_id', $this->userId)->orderBy('id', 'ASC')->get();

        return $rows->map(function (DetailItem $item) {
            return new CartItem($item->detail, $item->quantity);
        })->toArray();
    }

    public function save(array $items): void
    {
        DetailItem::where('user_id', $this->userId)->delete();

        /** @var CartItem $item */
        foreach ($items as $item) {
            DetailItem::create([
                'user_id' => $this->userId,
                'detail_id' => $item->getId(),
                'quantity' => $item->getQuantity(),
            ]);
        }
    }
}
