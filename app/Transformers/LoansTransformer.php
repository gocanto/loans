<?php

declare(strict_types=1);

namespace App\Transformers;

use App\Models\Loan;

final class LoansTransformer
{
    public function transform(Loan $loan): array
    {
        return [
            'uuid' => $loan->uuid,
            'user_uuid' => $loan->user->uuid,
            'description' => $loan->description,
            'lent_amount' => $loan->lent_amount,
            'payment_term' => $loan->payment_term,
            'payment_frequency' => $loan->payment_frequency,
            'created_at' => $loan->created_at,
            'updated_at' => $loan->updated_at,
            'deleted_at' => $loan->deleted_at,
        ];
    }
}
