<?php

namespace App\Http\Controllers\Api\V1\Manage\Product;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\V1\Manage\Product\StoreProductRequest;
use App\Http\Requests\Api\V1\Manage\Product\UpdateProductRequest;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class ProductController extends ApiController
{
    /**
     * @param ProductRepository $productRepository
     */
    public function __construct(private readonly ProductRepository $productRepository)
    {
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return !Gate::allows('product-index') ?
            $this->error('you cant see products list', HttpFoundationResponse::HTTP_UNAUTHORIZED) :
            $this->success(trans('product.manage.index'), $this->productRepository->paginate());
    }

    /**
     * @param StoreProductRequest $request
     * @return JsonResponse
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = $this->productRepository->create($request->validated());

        return $this->success(trans('product.manage.create'), $product,
            HttpFoundationResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return $this->success(trans('product.manage.show'), $product);
    }

    /**
     * @param UpdateProductRequest $request
     * @param Product $product
     * @return JsonResponse
     */
    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        $this->productRepository->update($request->validated(), $product);
        return $this->success(trans('product.manage.update'), $product);
    }

    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function destroy(Product $product): JsonResponse
    {
        $this->productRepository->destroy($product);

        return $this->success(trans('product.manage.destroy'), [],
            HttpFoundationResponse::HTTP_NO_CONTENT);
    }
}
