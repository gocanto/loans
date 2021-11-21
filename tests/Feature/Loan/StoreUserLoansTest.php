<?php

declare(strict_types=1);

namespace Tests\Feature\Loan;

use App\Models\Loan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\Feature\HasLoanMocks;
use Tests\TestCase;

class StoreUserLoansTest extends TestCase
{
    use RefreshDatabase;
    use HasLoanMocks;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createUser();
    }

    /**
     * @test
     */
    public function unauthorizedUsersAreNotAllowed(): void
    {
        $response = $this->get(\route('loans.store.user.loan', ['uuid' => 'foo']));

        self::assertSame(422, $response->getStatusCode());
        self::assertNotEmpty($response->json('errors.token'));
    }

    /**
     * @test
     */
    public function invalidUsersAreNotAllowed(): void
    {
        $response = $this->getResponse('foo');

        $response->assertStatus(404);
    }

    /**
     * @test
     */
    public function itGuardsAgainstInvalidRequests(): void
    {
       $this->getResponse($this->user->uuid, [
//                'description' => 'test 1',
            'lent_amount' => 100,
            'payment_term' => 'fixed',
            'payment_frequency' => 'weekly',
        ])
        ->assertStatus(422)
        ->assertJsonValidationErrorFor('description');

       $this->getResponse($this->user->uuid, [
            'description' => 'test 1',
//                'lent_amount' => 100,
            'payment_term' => 'fixed',
            'payment_frequency' => 'weekly',
        ])
       ->assertStatus(422)
       ->assertJsonValidationErrorFor('lent_amount');

        $this->getResponse($this->user->uuid, [
            'description' => 'test 1',
            'lent_amount' => 100,
            'payment_term' => 'foo', //it has to be `fixed` since it is the only allowed one for now.
            'payment_frequency' => 'weekly',
        ])
        ->assertStatus(422)
        ->assertJsonValidationErrorFor('payment_term');

        $this->getResponse($this->user->uuid, [
            'description' => 'test 1',
            'lent_amount' => 100,
            'payment_term' => 'fixed',
            'payment_frequency' => 'foo', //it has to be `weekly` since it is the only allowed one for now.
        ])
        ->assertStatus(422)
        ->assertJsonValidationErrorFor('payment_frequency');
    }

    /**
     * @test
     */
    public function itCreateValidLoansForGivenUsers(): void
    {
        self::assertCount(0, Loan::query()->get());

        $response = $this->getResponse($this->user->uuid, [
            'description' => 'test 1',
            'lent_amount' => 100,
            'payment_term' => 'fixed',
            'payment_frequency' => 'weekly',
        ]);

        $response->assertStatus(201);

        /** @var Loan $loan */
        $loan = Loan::query()->latest()->first();

        self::assertSame('test 1', $loan->description);
        self::assertSame(100.0000000000, (float) $loan->lent_amount);
        self::assertSame('fixed', $loan->payment_term);
        self::assertSame('weekly', $loan->payment_frequency);
        self::assertSame(4, $loan->payment_installments);
        self::assertNull($loan->deleted_at);
    }

    public function getResponse(string $userUuid, array $data = []): TestResponse
    {
        return $this->post(\route('loans.store.user.loan', ['uuid' => $userUuid]), $data, [
            'X-API-Key' => \config('loans.admin_token'),
        ]);
    }
}
