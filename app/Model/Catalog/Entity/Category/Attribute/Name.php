<?php

namespace App\Model\Catalog\Entity\Category\Attribute;

class Name
{
    private string $name;
    private ?string $label;
    private ?string $labelRu;

    public function __construct(string $name, ?string $label = null, ?string $labelRu = null)
    {
        $this->name = $name;
        $this->label = $label;
        $this->labelRu = $labelRu;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getLabelRu(): ?string
    {
        return $this->labelRu;
    }
}
