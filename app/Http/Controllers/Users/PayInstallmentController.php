<?php

declare(strict_types=1);

namespace App\Http\Controllers\Users;

use App\Models\Installment;
use App\Transformers\LoansTransformer;
use Carbon\CarbonImmutable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class PayInstallmentController
{
    public function __construct(private LoansTransformer $transformer)
    {
    }

    public function handle(Request $request): JsonResponse
    {
        /** @var Installment $installment */
        $installment = Installment::byUserAndLoanQuery(
            $request->route('userUuid'),
            $request->route('loanUuid')
        )
            ->where('uuid', $request->route('installmentUuid'))
            ->whereNull('paid_at')
            ->first();

        if ($installment === null) {
            return new JsonResponse([
                'message' => 'The given installment does not exist or is already paid.',
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        $installment->paid_at = CarbonImmutable::now();
        $installment->save();

        $installment = $installment->refresh();

        return new JsonResponse([
            'loans' => $this->transformer->transform($installment->loan)
        ]);
    }
}
