<?php

declare(strict_types=1);

namespace Tests\Builder;

use App\Entity\Catalog\Category;

class CategoryBuilder
{
    private string $name;
    private string $slug;
    private ?string $image;
    private ?Category $parent = null;

    public function __construct(string $name, string $slug, ?string $image = null)
    {
        $this->name = $name;
        $this->slug = $slug;
        $this->image = $image;
    }

    public function withParent(Category $category): self
    {
        $this->parent = $category;
        return $this;
    }

    public function build(): Category
    {
        $category = new Category();
        $category->name = $this->name;
        $category->slug = $this->slug;

        /*if($this->parent) {
            $category->parent_id = $this->parent;
        }*/

        return $category;
    }
}
