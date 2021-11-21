<?php

declare(strict_types=1);

namespace App\Http\Controllers\Users;

use App\Models\Loan;
use App\Transformers\LoansTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class LoansController
{
    public function __construct(private LoansTransformer $transformer)
    {
    }

    public function handle(Request $request): JsonResponse
    {
        $loans = Loan::byUserUuidQuery($request->route('uuid'))
            ->paginate()
            ->through(function (Loan $loan):array {
                return $this->transformer->transform($loan);
            });

        return new JsonResponse([
            'loans' => $loans
        ]);
    }
}
