<?php

declare(strict_types=1);

namespace App\Http\Controllers\Users;

use App\Models\Loan;
use App\Transformers\LoansTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class ShowLoanController
{
    public function __construct(private LoansTransformer $transformer)
    {
    }

    public function handle(Request $request): JsonResponse
    {
        /** @var Loan $loan */
        $loan = Loan::byUserUuidQuery($request->route('userUuid'))
            ->where('uuid', $request->route('loanUuid'))
            ->first();

        if ($loan === null) {
            return new JsonResponse([
                'message' => 'The given loan does not exist.',
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse([
            'loans' => $this->transformer->transform($loan)
        ]);
    }
}
