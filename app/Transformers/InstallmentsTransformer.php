<?php

declare(strict_types=1);

namespace App\Transformers;

use App\Models\Installment;
use Illuminate\Support\Collection;

final class InstallmentsTransformer
{
    public function transform(Installment $installment): array
    {
        return [
            'uuid' => $installment->uuid,
            'due_date' => $installment->due_date,
            'due_amount' => $installment->due_amount,
            'is_paid' => $installment->isPaid(),
            'paid_at' => $installment->paid_at,
            'created_at' => $installment->created_at,
            'updated_at' => $installment->updated_at,
            'deleted_at' => $installment->deleted_at,
        ];
    }

    /**
     * @param Installment[] $installments
     */
    public function collection(Collection $installments): array
    {
        return $installments
            ->map(fn (Installment $item) => $this->transform($item))
            ->toArray();
    }
}
