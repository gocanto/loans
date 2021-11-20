<?php

declare(strict_types=1);

namespace Tests\Feature\Model;

use App\Models\Installment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\HasLoanMocks;
use Tests\TestCase;

class LoanTest extends TestCase
{
    use RefreshDatabase;
    use HasLoanMocks;

    /**
     * @test
     */
    public function itHoldsValidInstallments(): void
    {
        $loan = $this->getLoan();

        /** @var Installment $installment */
        $installment = Installment::factory()->create([
            'loan_id' => $loan->id,
        ]);

        self::assertTrue($installment->loan->is($loan));
        self::assertCount(1, $loan->installments);
        self::assertInstanceOf(Installment::class, $loan->installments->first());
    }
}
