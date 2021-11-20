<?php

declare(strict_types=1);

namespace Database\Factories;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class InstallmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'uuid' => Str::uuid()->toString(),
            'due_date' => CarbonImmutable::now()->addMonths(3),
            'due_amount' => $this->faker->randomFloat(5, 2),
            'paid_at' => null,
        ];
    }
}
