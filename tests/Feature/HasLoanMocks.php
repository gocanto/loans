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

    protected function createLoan(User $user, array $attrs = []): Collection | Model | Loan
    {
        return Loan::factory()->create([
            'user_id' => $user->id,
        ]);
    }

    protected function getLoan(array $attrs = []): Collection | Model | Loan
    {
        /**
         * @var User $user
         * @var Loan[]|Collection $loans
         */

        $user = User::factory()->create();

        return $this->createLoan($user, $attrs);
    }

    protected function createInstallment(Loan $loan, array $attrs = []): Collection | Model | Installment
    {
        return Installment::factory(\array_merge([
            'loan_id' => $loan->id,
        ], $attrs))->create();
    }
}
