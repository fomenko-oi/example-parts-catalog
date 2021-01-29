<?php

declare(strict_types=1);

namespace App\Entity\Catalog\Model\Mark;

use Webmozart\Assert\Assert;

class Weight
{
    const TYPE_GR = 'gr';
    const TYPE_KG = 'kg';

    private ?float $value;
    private ?string $type;

    public function __construct(?float $value = null, ?string $type = null)
    {
        if ($type) {
            Assert::oneOf($type, array_keys(self::getTypesList()));
        }
        $this->value = $value;
        $this->type = $type;
    }

    public function getValue(): ?float
    {
        if ($this->isKg() && $this->value < 1000) {
            return $this->value * 1000;
        }
        return $this->value;
    }

    public function getType(): ?float
    {
        return $this->type;
    }

    public function getName(): string
    {
        if ($this->isKg() && $this->value < 1000) {
            return self::TYPE_GR;
        }
        return $this->type ? (self::getTypesList()[$this->type] ?? '') : '';
    }

    public function getFullKg()
    {
        return $this->value % 1000;
    }

    public function getFullGr()
    {
        return $this->value - $this->getFullKg() * 1000;
    }

    public function isKg(): bool
    {
        return  $this->type === self::TYPE_KG;
    }

    public function isGr(): bool
    {
        return  $this->type === self::TYPE_KG;
    }

    public static function getTypesList(): array
    {
        return [
            self::TYPE_GR => 'g',
            self::TYPE_KG => 'kg',
        ];
    }
}
