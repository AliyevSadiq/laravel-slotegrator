<?php

declare(strict_types=1);

namespace App\Virtual\Request\Product;

use Illuminate\Http\UploadedFile;

/**
 * @OA\Schema(
 *      title="Store product request",
 *      description="Store product request body data",
 *      type="object",
 *      required={"name", "description","category_id"}
 * )
 */
class StoreProductRequest
{


    /**
     * @OA\Property(
     *      title="name",
     *      description="Name",
     *      example="Product name"
     * )
     *
     * @var string
     */
    public string $name;

    /**
     * @OA\Property(
     *      title="description",
     *      description="Description",
     *      example="Product description"
     * )
     *
     * @var string
     */
    public string $description;


    /**
     * @OA\Property(
     *      title="category_id",
     *      description="Category id",
     *      example=1
     * )
     *
     * @var int
     */
    public int $category_id;

    /**
     * @OA\Property(
     *      property="images[]",
     *      title="images",
     *      description="Image",
     *      type="array",
     *      @OA\Items(
     *         type="file",
     *         format="binary",
     *     ),
     * )
     *
     * @var array
     */
    public array $images=[];

}
