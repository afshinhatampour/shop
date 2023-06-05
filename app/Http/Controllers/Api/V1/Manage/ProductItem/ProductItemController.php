<?php

namespace App\Http\Controllers\Api\V1\Manage\ProductItem;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\V1\Manage\ProductItem\StoreProductItemRequest;
use App\Http\Requests\Api\V1\Manage\ProductItem\UpdateProductItemRequest;
use App\Models\ProductItem;
use App\Repositories\ProductItemRepository;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class ProductItemController extends ApiController
{
    /**
     * @param ProductItemRepository $productItemRepository
     */
    public function __construct(private readonly ProductItemRepository $productItemRepository)
    {
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->success(trans('product_item.manage.index'), $this->productItemRepository->paginate());
    }

    /**
     * @param StoreProductItemRequest $request
     * @return JsonResponse
     */
    public function store(StoreProductItemRequest $request): JsonResponse
    {
        $productItem = $this->productItemRepository->create($request->validated());

        return $this->success(trans('product_item.manage.update'), $productItem,
            HttpFoundationResponse::HTTP_CREATED);
    }

    /**
     * @param ProductItem $productItem
     * @return JsonResponse
     */
    public function show(ProductItem $productItem): JsonResponse
    {
        return $this->success(trans('product_item.manage.show'), $productItem);
    }

    /**
     * @param UpdateProductItemRequest $request
     * @param ProductItem $productItem
     * @return JsonResponse
     */
    public function update(UpdateProductItemRequest $request, ProductItem $productItem): JsonResponse
    {
        $this->productItemRepository->update($request->validated(), $productItem);
        return $this->success(trans('product_item.manage.update'), $productItem);
    }

    /**
     * @param ProductItem $productItem
     * @return JsonResponse
     */
    public function destroy(ProductItem $productItem): JsonResponse
    {
        $this->productItemRepository->destroy($productItem);

        return $this->success(trans('product_item.manage.destroy'), [],
            HttpFoundationResponse::HTTP_NO_CONTENT);
    }
}
