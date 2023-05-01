<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResourceCollection;
use App\Repository\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        private ProductRepository $productRepository
    )
    {
    }

    /**
     * @OA\Get(
     *      path="/api/products",
     *       tags={"Product"},
     *      summary="Get list of products as a guest",
     *      description="Returns list of products",
     *      @OA\Parameter(
     *          name="category",
     *          description="Category slug",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="sort",
     *          description="Sort parameter",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *     )
     */
    public function index(Request $request)
    {
        $products = $this->productRepository->allProducts($request);
        return new ProductResourceCollection($products);
    }
}
