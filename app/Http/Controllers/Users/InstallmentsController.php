<?php

declare(strict_types=1);

namespace App\Http\Controllers\Users;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class InstallmentsController
{
    public function handle(Request $request): JsonResponse
    {
        return new JsonResponse('users-installments', $request->all());
    }
}
