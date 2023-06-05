<?php

namespace App\Http\Controllers\Api\V1\Manage;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\V1\Manage\Auth\LoginRequest;
use App\Http\Requests\Api\V1\Manage\Auth\RegisterRequest;
use App\Http\Resources\Api\V1\Manage\LoginResource;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends ApiController
{
    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        return Auth::attempt($request->validated()) ?
            $this->success(trans('user.manage.login.success'), (new LoginResource($this->getLoggedInUserInfo()))) :
            $this->error(trans('user.manage.login.failed'));
    }

    /**
     * @return array
     */
    protected function getLoggedInUserInfo(): array
    {
        return [
            'token' => auth()->user()->createToken('grant-token')->accessToken,
            'user'  => auth()->user()
        ];
    }

    /**
     * @param RegisterRequest $request
     * @param UserRepository $userRepository
     * @return JsonResponse
     */
    public function register(RegisterRequest $request, UserRepository $userRepository): JsonResponse
    {
        return $this->success(trans('user.manage.register'),
            $userRepository->create($request->validated()));
    }
}
