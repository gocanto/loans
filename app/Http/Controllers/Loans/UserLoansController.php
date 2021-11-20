<?php

declare(strict_types=1);

namespace App\Http\Controllers\Loans;

use App\Models\Loan;
use App\Transformers\LoansTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class UserLoansController
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
