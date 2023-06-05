<?php

namespace App\Http\Controllers\Api\V1\Manage\User;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\V1\Manage\User\StoreUserRequest;
use App\Http\Requests\Api\V1\Manage\User\UpdateUserRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class UserController extends ApiController
{
    /**
     * @param UserRepository $userRepository
     */
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->success(trans('user.manage.index'), $this->userRepository->paginate());
    }

    /**
     * @param StoreUserRequest $request
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $user = $this->userRepository->create($request->validated());

        return $this->success(trans('user.manage.create'), $user,
            HttpFoundationResponse::HTTP_CREATED);
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function show(User  $user): JsonResponse
    {
        return $this->success(trans('user.manage.show'), $user);
    }

    /**
     * @param UpdateUserRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $this->userRepository->update($request->validated(), $user);
        return $this->success(trans('user.manage.update'), $user);
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        $this->userRepository->destroy($user);

        return $this->success(trans('user.manage.destroy'), [],
            HttpFoundationResponse::HTTP_NO_CONTENT);
    }
}
