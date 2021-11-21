<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\Feature\HasLoanMocks;
use Tests\TestCase;

class ShowLoansTests extends TestCase
{
    use RefreshDatabase;
    use HasLoanMocks;

    /**
     * @test
     */
    public function itShowsOnlyGivenUsersLoans(): void
    {
        $loan = $this->getLoan();

        $this->createInstallment($loan);

        $response = $this->get(\route('user.loan', ['userUuid' => $loan->user->uuid, 'loanUuid' => $loan->uuid]));
        $response->assertSuccessful();

        $data = Collection::make($response->json('loans'));

        self::assertSame($loan->uuid, $data['uuid']);
    }
}
