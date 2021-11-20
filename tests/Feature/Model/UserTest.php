<?php

declare(strict_types=1);

namespace Tests\Feature\Model;

use App\Models\Loan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function itHoldsValidLoans(): void
    {
        /**
         * @var User $user
         * @var Loan[]|Collection $loans
         */

        $user = User::factory()->create();

        $loans = Loan::factory(2)->create([
            'user_id' => $user->id,
        ]);

        self::assertTrue($loans[0]->user->is($user));
        self::assertTrue($loans[1]->user->is($user));

        self::assertCount(2, $user->loans);

        self::assertInstanceOf(Loan::class, $user->loans->first());
        self::assertInstanceOf(User::class, $loans->first()->user);
    }
}
