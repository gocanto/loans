<?php

declare(strict_types=1);

namespace App\Http\Controllers\Loans;

use App\Models\User;
use Illuminate\Http\JsonResponse;

//all users
final class UsersController
{
    public function handle(): JsonResponse
    {
        return new JsonResponse([
            'users' => User::query()->paginate()->through(function (User $user):array {
                return [
                    'uuid' => $user->uuid,
                    'name' => $user->name,
                ];
            }),
        ]);
    }
}
