<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Installment;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait HasLoanMocks
{
    protected function createUser(array $attrs = []): User
    {
        return $user = User::factory()->create($attrs);
    }

    protected function getLoan(): Collection | Model | Loan
    {
        /**
         * @var User $user
         * @var Loan[]|Collection $loans
         */

        $user = User::factory()->create();

        return Loan::factory()->create([
            'user_id' => $user->id,
        ]);
    }

    protected function createInstallment(Loan $loan): Collection | Model | Installment
    {
        return Installment::factory([
            'loan_id' => $loan->id,
        ])->create();
    }
}
