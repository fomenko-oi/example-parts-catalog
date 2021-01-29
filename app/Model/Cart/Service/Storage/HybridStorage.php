<?php

declare(strict_types=1);

namespace App\Model\Cart\Service\Storage;

use App\Model\Cart\Service\CartItem;
use Auth;

class HybridStorage implements StorageInterface
{
    private $storage;
    private $cookieKey;
    private $cookieTimeout;

    public function __construct($cookieKey, $cookieTimeout)
    {
        $this->cookieKey = $cookieKey;
        $this->cookieTimeout = $cookieTimeout;
    }

    public function load(): array
    {
        return $this->getStorage()->load();
    }

    public function save(array $items): void
    {
        $this->getStorage()->save($items);
    }

    private function getStorage()
    {
        if ($this->storage === null) {
            $cookieStorage = new CookieStorage($this->cookieKey, $this->cookieTimeout);
            if (Auth::guest()) {
                $this->storage = $cookieStorage;

                return $this->storage;
            }

            $dbStorage = new DbStorage(Auth::id());
            if ($cookieItems = $cookieStorage->load()) {
                $dbItems = $dbStorage->load();
                $items = array_merge($dbItems, array_udiff($cookieItems, $dbItems, function (CartItem $first, CartItem $second) {
                    return $first->getId() === $second->getId();
                }));
                $dbStorage->save($items);
                $cookieStorage->save([]);
            }
            $this->storage = $dbStorage;
        }
        return $this->storage;
    }
}
