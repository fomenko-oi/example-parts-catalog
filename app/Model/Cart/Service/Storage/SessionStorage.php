<?php

declare(strict_types=1);

namespace App\Model\Cart\Service\Storage;

use Illuminate\Support\Facades\Session;

class SessionStorage implements StorageInterface
{
    private $key;
    private $session;

    public function __construct($key, Session $session)
    {
        $this->key = $key;
        $this->session = $session;
    }

    public function load(): array
    {
        return $this->session->get($this->key, []);
    }

    public function save(array $items): void
    {
        $this->session->put($this->key, $items);
    }
}
