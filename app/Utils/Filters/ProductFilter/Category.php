<?php


namespace App\Utils\Filters\ProductFilter;

use App\Utils\Filters\FilterContract;

class Category implements FilterContract
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function handle($value = null): void
    {
        $this->query->whereHas('category',function ($query) use($value){
            $query->where('slug',$value);
        });
    }
}
