<?php

namespace App\Http\Controllers\Api\Authorized;

use App\CommandBus\API\Product\Commands\DeleteProductCommand;
use App\CommandBus\API\Product\Commands\SaveProductCommand;
use App\CommandBus\Core\Contract\CommandBusInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ProductCreateRequest;
use App\Http\Requests\Api\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductResourceCollection;
use App\Models\Product;
use App\Repository\ProductRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    public function __construct(
        private ProductRepository $productRepository,
        private CommandBusInterface $commandBus
    )
    {
    }

    /**
     * @OA\Get(
     *      path="/api/auth/products",
     *       tags={"Auth Product"},
     *      summary="Get list of products",
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
     *     security={{"sanctum":{}}},
     *     )
     */
    public function index(Request $request)
    {
        $products = $this->productRepository->allProducts($request);
        return new ProductResourceCollection($products);
    }

    /**
     * @OA\Post(
     *      tags={"Auth Product"},
     *      path="/api/auth/products",
     *      operationId="store product",
     *      summary="Store Product",
     *      description="Store Product",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema (ref="#/components/schemas/StoreProductRequest")
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *      ),
     *      security={{"sanctum":{}}},
     *
     * )
     * @param ProductCreateRequest $request
     * @return JsonResponse|ProductResource
     */
    public function store(ProductCreateRequest $request): JsonResponse|ProductResource
    {
        try {
            $command = new SaveProductCommand();
            $this->commandBus->dispatch($command, $request->all());
            return new ProductResource($command->product);
        } catch (\Exception $exception) {
            return $this->jsonError($exception->getMessage());
        }
    }

    /**
     * @OA\Post(
     *      tags={"Auth Product"},
     *      path="/api/auth/products/{product}",
     *      operationId="update product",
     *      summary="Update Product",
     *      description="Update Product",
     *      @OA\Parameter(
     *          name="product",
     *          description="Product id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema (ref="#/components/schemas/StoreProductRequest")
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *      ),
     *      security={{"sanctum":{}}},
     *
     * )
     * @param ProductCreateRequest $request
     * @return JsonResponse|ProductResource
     */
    public function update(Product $product, ProductUpdateRequest $request)
    {
        try {
            $command = new SaveProductCommand();
            $request->request->add(['product' => $product]);
            $this->commandBus->dispatch($command, $request->all());
            return new ProductResource($command->product);
        } catch (\Exception $exception) {
            return $this->jsonError($exception->getMessage());
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/auth/products/{product}",
     *       tags={"Auth Product"},
     *      summary="Delete product",
     *      description="Delete product",
     *      @OA\Parameter(
     *          name="product",
     *          description="Product id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *     security={{"sanctum":{}}},
     *     )
     */
    public function destroy(Product $product, Request $request)
    {
        try {
            $command = new DeleteProductCommand();
            $request->request->add(['product' => $product]);
            $this->commandBus->dispatch($command, $request->all());
            return $this->jsonSuccess('Product deleted')
                ->setStatusCode(Response::HTTP_NO_CONTENT);
        } catch (\Exception $exception) {
            return $this->jsonError($exception->getMessage());
        }
    }
}
