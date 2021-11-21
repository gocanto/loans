<?php

declare(strict_types=1);

namespace Tests\Feature\Model;

use App\Entities\Frequency;
use App\Models\Installment;
use App\Models\Loan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Tests\Feature\HasLoanMocks;
use Tests\TestCase;

class LoanTest extends TestCase
{
    use RefreshDatabase;
    use HasLoanMocks;

    /**
     * @test
     */
    public function itHoldsValidPaymentTerms(): void
    {
        self::assertCount(1, Loan::paymentTerms());
        self::assertCount(1, Loan::paymentFrequencies());

        self::assertArrayHasKey('fixed', Loan::paymentTerms());
        self::assertArrayHasKey('weekly', Loan::paymentFrequencies());

        /** @var Frequency $weekly */
        $weekly = Arr::get(Loan::paymentFrequencies(), 'weekly');
        self::assertSame('Weekly', $weekly->label);
        self::assertSame(4, $weekly->installments);
    }

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

    /**
     * @test
     */
    public function testingThisCode(): void
    {
        //term: fixed
        //payment frequency: weekly
        //due date.
    }
}
