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
    private CarbonImmutable $now;

    public function __construct()
    {
        $this->now = CarbonImmutable::parse('2022-01-01')->startOfDay();

        $this->user = User::factory()->create([
            'name' => 'Gus',
            'email' => 'gus@loans.local',
            'uuid' => 'af13b8eb-a258-4ddf-b51d-9b55a52834d7',
        ]);
    }

    public function run(): void
    {
        $this->createLoan('fdb7c9cf-c20c-478f-8def-596229afec0c', ['description' => 'Loan 001', 'lent_amount' => 100]);
        $this->createLoan('d77c1bbe-fec1-419f-a574-1c149c4c59cc', ['description' => 'Loan 002', 'lent_amount' => 200]);
        $this->createLoan('7aca94e6-ed0e-4ed5-adbc-005812dc2734', ['description' => 'Loan 003', 'lent_amount' => 300]);
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
