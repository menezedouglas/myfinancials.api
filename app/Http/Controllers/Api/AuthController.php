<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\Exception;
use App\Http\Controllers\Controller;
use App\Http\Resources\DefaultResource;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @param Request $request
     * @return DefaultResource
     * @throws Exception
     */
    public function store(Request $request): DefaultResource
    {
        try {
            return new DefaultResource(
                $this->authService->login(
                    $request->input('email'),
                    $request->input('password')
                )
            );
        } catch (\Throwable $exception) {
            throw new Exception($exception);
        }
    }

    /**
     * @throws Exception
     */
    public function destroy(): DefaultResource
    {
        try {
            $this->authService->logout();
            return new DefaultResource([]);
        } catch (\Throwable $exception) {
            throw new Exception($exception);
        }
    }
}
