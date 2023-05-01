<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Product;
use App\Utils\Sorting\ProductSorting;
use Illuminate\Http\Request;

class ProductRepository
{

    public function allProducts(Request $request)
    {
       return Product::with(['category','user','images','favorites'])
           ->filterBy($request->all())
           ->orderByDesc(ProductSorting::sorting($request->get('sort')))
           ->paginate(config('pagination.product'));
    }
}
