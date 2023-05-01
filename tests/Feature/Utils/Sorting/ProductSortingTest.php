<?php

namespace Tests\Feature\Utils\Sorting;

use App\Enums\ProductSortType;
use App\Utils\Sorting\ProductSorting;
use Tests\TestCase;

class ProductSortingTest extends TestCase
{
    public function testSortingByName()
    {
        $sorting = ProductSorting::sorting(ProductSortType::NAME);
        $this->assertEquals('name', $sorting);
    }

    public function testSortingByCategory()
    {
        $sorting = ProductSorting::sorting(ProductSortType::CATEGORY);
        $this->assertEquals('category_id', $sorting);
    }

    public function testSortingByDefault()
    {
        $sorting = ProductSorting::sorting();
        $this->assertEquals('id', $sorting);
    }
}
