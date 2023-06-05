<?php

namespace App\Http\Controllers\Api\V1\Manage\Role;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\V1\Manage\Role\StoreRoleRequest;
use App\Http\Requests\Api\V1\Manage\Role\UpdateRoleRequest;
use App\Models\Role;
use App\Repositories\RoleRepository;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class RoleController extends ApiController
{
    public function __construct(private readonly RoleRepository $roleRepository)
    {
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->success(trans('role.manage.index'), $this->roleRepository->paginate());
    }

    /**
     * @param StoreRoleRequest $request
     * @return JsonResponse
     */
    public function store(StoreRoleRequest $request): JsonResponse
    {
        $role = $this->roleRepository->create($request->validated());

        return $this->success(trans('role.manage.create'), $role,
            HttpFoundationResponse::HTTP_CREATED);
    }

    /**
     * @param Role $role
     * @return JsonResponse
     */
    public function show(Role $role): JsonResponse
    {
        return $this->success(trans('role.manage.show'), $role);
    }

    /**
     * @param UpdateRoleRequest $request
     * @param Role $role
     * @return JsonResponse
     */
    public function update(UpdateRoleRequest $request, Role $role): JsonResponse
    {
        $this->roleRepository->update($request->validated(), $role);
        return $this->success(trans('role.manage.update'), $role);
    }

    /**
     * @param Role $role
     * @return JsonResponse
     */
    public function destroy(Role $role): JsonResponse
    {
        $this->roleRepository->destroy($role);
        return $this->success(trans('role.manage.destroy'), [],
            HttpFoundationResponse::HTTP_NO_CONTENT);
    }
}
