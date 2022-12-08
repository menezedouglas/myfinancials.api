<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

abstract class AbstractService
{
    protected $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    protected function getAuthenticatedUser(): User
    {
        return User::withoutTrashed()
            ->where('id', $this->auth::id())
            ->first();
    }
}
