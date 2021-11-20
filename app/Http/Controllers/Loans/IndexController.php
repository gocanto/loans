<?php

declare(strict_types=1);

namespace App\Http\Controllers\Loans;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class IndexController
{
    public function handle(Request $request): JsonResponse
    {
        return new JsonResponse('loans-index', $request->all());
    }
}
