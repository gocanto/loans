<?php

declare(strict_types=1);

namespace App\Http\Controllers\Users;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class PayInstallmentController
{
    public function handle(Request $request): JsonResponse
    {
        return new JsonResponse('users-pay', $request->all());
    }
}
