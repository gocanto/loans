<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

//Handle basic/manual admin authorization.
class AdminUsersMiddleware
{
    public function handle(Request $request, Closure $next): Response | JsonResponse
    {
        if ($this->hasValidToken($request)) {
            return $next($request);
        }

        return new Response([
            'message' => 'Unauthorized request.',
            'errors' => [
                'token' => 'The given API token is unauthorized.'
            ],
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    private function hasValidToken(Request $request): bool
    {
        $token = $request->header('X-API-Key');

        return $token === \config('loans.admin_token');
    }
}
