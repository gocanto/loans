<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Installment;
use App\Models\Loan;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    private User $user;
    private User $user2;
    private CarbonImmutable $now;

    public function __construct()
    {
        $this->now = CarbonImmutable::parse('2022-01-01')->startOfDay();

        $this->user = User::factory()->create([
            'name' => 'Gus',
            'email' => 'gus@loans.local',
            'uuid' => 'af13b8eb-a258-4ddf-b51d-9b55a52834d7',
        ]);

        $this->user2 = User::factory()->create([
            'name' => 'Li',
            'email' => 'li@loans.local',
            'uuid' => '60d2dd8e-01e4-40f2-a1a4-0d35c9d2b13d',
        ]);
    }

    public function run(): void
    {
        $this->createLoan('fdb7c9cf-c20c-478f-8def-596229afec0c', ['description' => 'Loan 001', 'lent_amount' => 100]);
        $this->createLoan('d77c1bbe-fec1-419f-a574-1c149c4c59cc', ['description' => 'Loan 002', 'lent_amount' => 200]);
        $this->createLoan('7aca94e6-ed0e-4ed5-adbc-005812dc2734', ['description' => 'Loan 003', 'lent_amount' => 300]);

        $this->createLoan2('52832998-1b53-470f-99ee-9c99880b9494', ['description' => 'Loan 001', 'lent_amount' => 100]);
        $this->createLoan2('5c34ef1c-8bed-4a2d-98fe-7ab4d19639e7', ['description' => 'Loan 002', 'lent_amount' => 200]);
        $this->createLoan2('681d727c-14b8-4aa6-8938-ac152ca634b2', ['description' => 'Loan 003', 'lent_amount' => 300]);
    }

    private function createLoan(string $uuid, array $attrs) : void
    {
        /** @var Loan $loan */
        $loan = Loan::factory()->create(\array_merge([
            'uuid' => $uuid,
            'user_id' => $this->user->id
        ], $attrs));

        $this->createInstallments($loan);
    }

    private function createLoan2(string $uuid, array $attrs) : void
    {
        /** @var Loan $loan */
        $loan = Loan::factory()->create(\array_merge([
            'uuid' => $uuid,
            'user_id' => $this->user2->id
        ], $attrs));

        $this->createInstallments($loan);
    }

    private function createInstallments(Loan $loan): void
    {
        $amount = $loan->lent_amount / 2; //we assume same amount installments.

        Installment::factory()->create([
            'loan_id' => $loan->id,
            'due_date' => $this->now->toDateString(),
            'due_amount' => $amount,
            'paid_at' => $this->now,
        ]);

        Installment::factory()->create([
            'loan_id' => $loan->id,
            'due_date' => $this->now->addWeek()->toDateString(),
            'due_amount' => $amount,
            'paid_at' => null,
        ]);
    }
}
