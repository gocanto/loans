<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class LoansController
{
    public function handle(Request $request): JsonResponse
    {
        return new JsonResponse('create-ok');
    }
}
