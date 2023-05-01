<?php

declare(strict_types=1);

namespace App\Repository;

use App\Utils\Sorting\ProductSorting;
use Illuminate\Http\Request;

class FavoriteRepository
{

    public function list(Request $request)
    {
        return auth()->user()->favorites()
            ->with(['product' => function ($query) use ($request) {
                $query->with(['category', 'user', 'images'])
                    ->orderByDesc(ProductSorting::sorting($request->get('sort')));
            }])->whereHas('product', function ($query) use ($request) {
                $query->filterBy($request->all());
            })
            ->paginate(config('pagination.favorite'));
    }
}
