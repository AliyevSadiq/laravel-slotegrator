<?php


namespace App\Utils\Sorting;

use App\Enums\ProductSortType;

class ProductSorting implements SortingContract
{

    public static function sorting($value = null): string
    {
            return match ($value) {
                ProductSortType::NAME => 'name',
                ProductSortType::CATEGORY => 'category_id',
                default => 'id',
            };
    }
}
