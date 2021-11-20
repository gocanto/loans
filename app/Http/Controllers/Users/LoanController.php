<?php

declare(strict_types=1);

namespace App\Http\Controllers\Users;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class LoanController
{
    public function handle(Request $request): JsonResponse
    {
        return new JsonResponse('users-loan', $request->all());
    }
}
