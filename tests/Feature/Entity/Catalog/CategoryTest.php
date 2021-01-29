<?php

namespace Tests\Feature\Entity\Catalog;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Builder\CategoryBuilder;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function testyCreate()
    {
        $category = (new CategoryBuilder($name = 'testname', $slug = 'testslug'))->build();

        $this->assertEquals($name, $category->name);
        $this->assertEquals($slug, $category->slug);
    }
}
