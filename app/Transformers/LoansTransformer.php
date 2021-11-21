<?php

declare(strict_types=1);

namespace App\Transformers;

use App\Models\Loan;

final class LoansTransformer
{
    public function __construct(private InstallmentsTransformer $installments)
    {
    }

    public function transform(Loan $loan): array
    {
        return [
            'uuid' => $loan->uuid,
            'user_uuid' => $loan->user->uuid,
            'description' => $loan->description,
            'lent_amount' => $loan->lent_amount,
            'payment_term' => $loan->payment_term,
            'payment_frequency' => $loan->payment_frequency,
            'payment_installments' => $loan->payment_installments,
            'installments' => $this->installments->collection($loan->installments()->get()),
            'created_at' => $loan->created_at,
            'updated_at' => $loan->updated_at,
            'deleted_at' => $loan->deleted_at,
        ];
    }
}
