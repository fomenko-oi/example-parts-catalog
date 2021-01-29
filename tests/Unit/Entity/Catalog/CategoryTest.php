<?php

namespace Tests\Unit\Entity\Catalog;

use App\Entity\Catalog\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\TestCase;
use Tests\Builder\CategoryBuilder;

class CategoryTest extends TestCase
{
    public function testyCreate()
    {
        $category = (new CategoryBuilder($name = 'testname', $slug = 'testslug'))->build();

        $this->assertEquals($name, $category->name);
        $this->assertEquals($slug, $category->slug);
    }

    public function testWithParent()
    {
        $category = (new CategoryBuilder($name = 'testname', $slug = 'testslug'))
            ->withParent(
                $parent = (new CategoryBuilder($name = 'testname2', $slug = 'testslug2'))->build()
            )
            ->build();

        $this->assertTrue($category->hasParent());
        $this->assertEquals($category->parent, $parent);
    }
}
