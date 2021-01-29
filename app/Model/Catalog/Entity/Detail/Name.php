<?php

declare(strict_types=1);

namespace App\Model\Catalog\Entity\Detail;

use Webmozart\Assert\Assert;

class Name
{
    private string $name;
    private string $catNumber;
    private ?string $description;
    private ?string $nameRu;
    private ?string $nameEn;

    public function __construct(string $name, string $catNumber, ?string $nameEn = null, ?string $nameRu = null, ?string $description = null)
    {
        Assert::notEmpty($name);
        Assert::notEmpty($catNumber);

        $this->name = $name;
        $this->catNumber = $catNumber;
        $this->description = $description;
        $this->nameRu = $nameRu;
        $this->nameEn = $nameEn;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getCatNumber(): string
    {
        return $this->catNumber;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return string|null
     */
    public function getNameRu(): ?string
    {
        return $this->nameRu;
    }

    /**
     * @return string|null
     */
    public function getNameEn(): ?string
    {
        return $this->nameEn;
    }
}
