<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Models\Installment;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\Feature\HasLoanMocks;
use Tests\TestCase;

class PayInstallmentTests extends TestCase
{
    use RefreshDatabase;
    use HasLoanMocks;

    /**
     * @test
     */
    public function itProperlyMarkInstallmentsAsPaid(): void
    {
        $loan = $this->getLoan();

        $installment = $this->createInstallment($loan);

        self::assertTrue($installment->isPending());

        $response = $this->post(\route('user.pay.installment', [
            'userUuid' => $loan->user->uuid,
            'loanUuid' => $loan->uuid,
            'installmentUuid' => $installment->uuid,
        ]));

        $response->assertSuccessful();

        $data = Collection::make($response->json('loans'));

        self::assertSame($loan->uuid, $data['uuid']);
        self::assertSame($loan->user->uuid, $data['user_uuid']);

        $loan = $loan->refresh();

        /** @var Installment $foundInstallment */
        $foundInstallment = $loan->installments->first();

        self::assertTrue($foundInstallment->isPaid());
        self::assertSame($foundInstallment->uuid, $data['installments'][0]['uuid']);
    }

    /**
     * @test
     */
    public function itRejectsPaidInstallments(): void
    {
        $loan = $this->getLoan();

        $installment = $this->createInstallment($loan, [
            'paid_at' => CarbonImmutable::now(),
        ]);

        self::assertTrue($installment->isPaid());

        $response = $this->post(\route('user.pay.installment', [
            'userUuid' => $loan->user->uuid,
            'loanUuid' => $loan->uuid,
            'installmentUuid' => $installment->uuid,
        ]));

        $response->assertStatus(404);
        self::assertNotEmpty($response->json('message'));
    }

    /**
     * @test
     */
    public function itRejectsNotFoundInstallments(): void
    {
        $loan = $this->getLoan();
        $this->createInstallment($loan);

        $response = $this->post(\route('user.pay.installment', [
            'userUuid' => $loan->user->uuid,
            'loanUuid' => $loan->uuid,
            'installmentUuid' => 'foo',
        ]));

        $response->assertStatus(404);
        self::assertNotEmpty($response->json('message'));
    }

    /**
     * @test
     */
    public function installmentsHaveToBelongToTheSameUsersAndLoans(): void
    {
        $userA = $this->createUser();
        $userB = $this->createUser();

        $loanA = $this->createLoan($userA);
        $loanB = $this->createLoan($userB);

        $installmentA = $this->createInstallment($loanA);
        $installmentB = $this->createInstallment($loanB);

        $response = $this->post(\route('user.pay.installment', [
            'userUuid' => $loanA->user->uuid,
            'loanUuid' => $loanA->uuid,
            'installmentUuid' => $installmentB->uuid,
        ]));

        $response->assertStatus(404);
        self::assertNotEmpty($response->json('message'));
    }
}
