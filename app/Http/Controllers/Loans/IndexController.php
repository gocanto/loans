<?php

declare(strict_types=1);

namespace App\Http\Controllers\Loans;

use App\Models\Loan;
use App\Transformers\LoansTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

//all loans
final class IndexController
{
    public function __construct(private LoansTransformer $transformer)
    {
    }

    public function handle(Request $request): JsonResponse
    {
        $perPage = $request->input('perPage', 50);
        $page = $request->input('page');

        return new JsonResponse([
            'loans' => Loan::query()
                ->paginate($perPage, ['*'], 'page', $page)
                ->through(function (Loan $loan):array {
                    return $this->transformer->transform($loan);
                }),
        ]);
    }
}
