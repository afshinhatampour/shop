<?php

namespace App\Http\Controllers\Api\V1\Manage\Permission;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Models\Permission;
use App\Repositories\PermissionRepository;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class PermissionController extends ApiController
{
    public function __construct(private readonly PermissionRepository $permissionRepository)
    {
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->success(trans('permission.manage.index'), $this->permissionRepository->paginate());
    }

    /**
     * @param StorePermissionRequest $request
     * @return JsonResponse
     */
    public function store(StorePermissionRequest $request): JsonResponse
    {
        $role = $this->permissionRepository->create($request->validated());

        return $this->success(trans('permission.manage.create'), $role,
            HttpFoundationResponse::HTTP_CREATED);
    }

    /**
     * @param Permission $permission
     * @return JsonResponse
     */
    public function show(Permission $permission): JsonResponse
    {
        return $this->success(trans('permission.manage.show'), $permission);
    }

    /**
     * @param UpdatePermissionRequest $request
     * @param Permission $permission
     * @return JsonResponse
     */
    public function update(UpdatePermissionRequest $request, Permission $permission): JsonResponse
    {
        $this->permissionRepository->update($request->validated(), $permission);
        return $this->success(trans('permission.manage.update'), $permission);
    }

    /**
     * @param Permission $permission
     * @return JsonResponse
     */
    public function destroy(Permission $permission): JsonResponse
    {
        $this->permissionRepository->destroy($permission);
        return $this->success(trans('permission.manage.destroy'), [],
            HttpFoundationResponse::HTTP_NO_CONTENT);
    }
}
