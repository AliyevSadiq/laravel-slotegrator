<?php

namespace App\Http\Controllers\Api\Authorized;

use App\CommandBus\API\Favorite\Commands\DeleteFavoriteCommand;
use App\CommandBus\API\Favorite\Commands\StoreFavoriteCommand;
use App\CommandBus\Core\Contract\CommandBusInterface;
use App\Http\Controllers\Controller;
use App\Http\Resources\FavoriteResourceCollection;
use App\Models\Favorite;
use App\Models\Product;
use App\Repository\FavoriteRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FavoriteController extends Controller
{

    public function __construct(
        private FavoriteRepository $favoriteRepository,
        private CommandBusInterface $commandBus
    )
    {
    }

    /**
     * @OA\Get(
     *      path="/api/auth/favorites",
     *       tags={"Favorite"},
     *      summary="Get list of favorite products",
     *      description="Returns list of favorite products",
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
    public function index(Request $request): FavoriteResourceCollection
    {
        $favorites = $this->favoriteRepository->list($request);
        return new FavoriteResourceCollection($favorites);
    }

    /**
     * @OA\Post(
     *      path="/api/auth/favorites/{product}",
     *       tags={"Favorite"},
     *      summary="Add product  favorite list",
     *      description="Add product  favorite list",
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
    public function store(Product $product)
    {
        try {
            $command = new StoreFavoriteCommand();
            $this->commandBus->dispatch($command, [
                'product' => $product
            ]);
            return $this->jsonSuccess('Product added to favorite list');
        } catch (\Exception $exception) {
            return $this->jsonError($exception->getMessage());
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/auth/favorites/{favorite}",
     *       tags={"Favorite"},
     *      summary="Remove product from favorite list",
     *      description="Remove product from favorite list",
     *      @OA\Parameter(
     *          name="favorite",
     *          description="Favorite id",
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
    public function delete(Favorite $favorite): \Illuminate\Http\JsonResponse
    {
        try {
            $command = new DeleteFavoriteCommand();
            $this->commandBus->dispatch($command, [
                'favorite' => $favorite
            ]);
            return $this->jsonSuccess('Product deleted from favorite list');
        } catch (\Exception $exception) {
            return $this->jsonError($exception->getMessage());
        }
    }
}
