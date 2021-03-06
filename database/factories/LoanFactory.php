<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Loan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class LoanFactory extends Factory
{
    public function definition(): array
    {
        return [
            'uuid' => Str::uuid()->toString(),
            'description' => $this->faker->text(),
            'lent_amount' => $this->faker->randomFloat(5, 2),
            'payment_term' => Loan::defaultPaymentTerm(),
            'payment_frequency' => Loan::defaultPaymentFrequency()->slug,
            'payment_installments' => Loan::defaultPaymentFrequency()->installments,
        ];
    }
}
