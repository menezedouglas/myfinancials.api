<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\Exception;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\NewUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\DefaultResource;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @return DefaultResource
     * @throws Exception
     */
    public function index(): DefaultResource
    {
        try {
            return new DefaultResource(
                $this->userService->profile()
            );
        } catch (\Throwable $exception) {
            throw new Exception($exception);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param NewUserRequest $request
     * @return DefaultResource
     * @throws Exception
     */
    public function store(NewUserRequest $request): DefaultResource
    {
        try {
            return new DefaultResource(
                $this->userService->register(
                    $request->input('name'),
                    $request->input('email'),
                    $request->input('password'),
                    $request->input('privacy_policy'),
                    $request->input('service_terms')
                )
            );
        } catch (\Throwable $exception) {
            throw new Exception($exception);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @return DefaultResource
     * @throws Exception
     */
    public function update(UpdateUserRequest $request): DefaultResource
    {
        try {
            return new DefaultResource(
                $this->userService->update(
                    $request->input('name'),
                    $request->input('email'),
                    $request->input('password')
                )
            );
        } catch (\Throwable $exception) {
            throw new Exception($exception);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return DefaultResource
     * @throws Exception
     */
    public function destroy(): DefaultResource
    {
        try {
            $this->userService->delete();
            return new DefaultResource([]);
        } catch (\Throwable $exception) {
            throw new Exception($exception);
        }
    }
}
