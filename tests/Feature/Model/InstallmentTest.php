<?php

declare(strict_types=1);

namespace Tests\Feature\Model;

use App\Models\Installment;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\HasLoanMocks;
use Tests\TestCase;

class InstallmentTest extends TestCase
{
    use RefreshDatabase;
    use HasLoanMocks;

    protected function setUp(): void
    {
        parent::setUp();

        CarbonImmutable::setTestNow('2021-11-20');
    }

    /**
     * @test
     */
    public function itHoldsValidInformation(): void
    {
        $loan = $this->getLoan();

        /** @var Installment $installment */
        $installment = Installment::factory()->create([
            'loan_id' => $loan->id,
        ]);

        self::assertTrue($installment->isPending());

        $installment->paid_at = CarbonImmutable::now();
        $installment->save();

        $installment = $installment->fresh();

        self::assertTrue($installment->isPaid());
    }

//    private function getLoan(): Collection | Model | Loan
//    {
//        /**
//         * @var User $user
//         * @var Loan[]|Collection $loans
//         */
//
//        $user = User::factory()->create();
//
//        return Loan::factory()->create([
//            'user_id' => $user->id,
//        ]);
//    }
}
