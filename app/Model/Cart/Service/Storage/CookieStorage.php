<?php

declare(strict_types=1);

namespace App\Model\Cart\Service\Storage;

use App\Entity\Catalog\Model\Mark\Detail;
use App\Model\Cart\Service\CartItem;
use Illuminate\Support\Facades\Cookie;

class CookieStorage implements StorageInterface
{
    private $key;
    private $timeout;

    public function __construct($key, $timeout)
    {
        $this->key = $key;
        $this->timeout = $timeout;
    }

    public function load(): array
    {
        if ($value = Cookie::get($this->key)) {
            $data = json_decode($value, true);
            if (!$data) {
                return [];
            }

            return array_filter(array_map(function (array $row) {
                if (isset($row['d'], $row['q']) && $detail = Detail::find($row['d'])) {
                    /** @var Detail $detail */
                    return new CartItem($detail, $row['q']);
                }
                return false;
            }, $data));
        }
        return [];
    }

    public function save(array $items): void
    {
        Cookie::queue($this->key, json_encode(array_map(function (CartItem $item) {
            return [
                'd' => $item->getId(),
                'q' => $item->getQuantity(),
            ];
        }, $items)), time() + $this->timeout);
    }
}
