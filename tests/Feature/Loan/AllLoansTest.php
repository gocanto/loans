<?php

declare(strict_types=1);

namespace Tests\Feature\Loan;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\Feature\HasLoanMocks;
use Tests\TestCase;

class AllLoansTest extends TestCase
{
    use RefreshDatabase;
    use HasLoanMocks;

    /**
     * @test
     */
    public function unauthorizedUsersAreNotAllowed(): void
    {
        $response = $this->get(\route('loans.index'));

        self::assertSame(422, $response->getStatusCode());
        self::assertNotEmpty($response->json('errors.token'));
    }

    /**
     * @test
     */
    public function authorizedUsersAreAllowed(): void
    {
        $loan = $this->getLoan();
        $installment = $this->createInstallment($loan);

        $response = $this->get(\route('loans.index'), [
            'X-API-Key' => \config('loans.admin_token')
        ]);

        $response->assertSuccessful();

        $data = Collection::make($response->json('loans.data'));

        self::assertCount(1, $data);
        self::assertEquals($loan->uuid, $data[0]['uuid']);
        self::assertEquals($installment->uuid, $data[0]['installments'][0]['uuid']);
    }
}
