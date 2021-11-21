<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\Feature\HasLoanMocks;
use Tests\TestCase;

class LoansTests extends TestCase
{
    use RefreshDatabase;
    use HasLoanMocks;

    /**
     * @test
     */
    public function itShowsOnlyGivenUsersLoans(): void
    {
        $loanA = $this->getLoan();
        $loanB = $this->getLoan();

        $this->createInstallment($loanA);
        $this->createInstallment($loanB);

        $response = $this->get(\route('user.loans', ['userUuid' => $loanA->user->uuid]));
        $response->assertSuccessful();

        $data = Collection::make($response->json('loans.data'));

        self::assertCount(1, $data);
        self::assertSame($data[0]['description'], $loanA->description);
        self::assertEquals($data[0]['lent_amount'], $loanA->lent_amount);
        self::assertSame($data[0]['payment_term'], $loanA->payment_term);
        self::assertSame($data[0]['payment_frequency'], $loanA->payment_frequency);
        self::assertSame($data[0]['payment_installments'], $loanA->payment_installments);

        $installmentAResponse = $data[0]['installments'][0];
        $installmentABody = $loanA->installments->first()->toArray();

        self::assertSame($installmentAResponse['uuid'], $installmentABody['uuid']);
        self::assertSame($installmentAResponse['due_date'], $installmentABody['due_date']);
        self::assertSame($installmentAResponse['due_amount'], $installmentABody['due_amount']);
        self::assertSame($installmentAResponse['paid_at'], $installmentABody['paid_at']);

        // --- loan B

        $response = $this->get(\route('user.loans', ['userUuid' => $loanB->user->uuid]));
        $response->assertSuccessful();

        $data = Collection::make($response->json('loans.data'));

        self::assertCount(1, $data);
        self::assertNotSame($data[0]['uuid'], $loanA->uuid);
    }
}
