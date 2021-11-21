<?php

declare(strict_types=1);

namespace Tests\Unit\Entities;

use App\Entities\Frequency;
use PHPUnit\Framework\TestCase;

class FrequencyTest extends TestCase
{
    /**
     * @test
     */
    public function itHoldsValidValues(): void
    {
        $frequency = Frequency::make('foo', 'bar', 2);

        self::assertSame('foo', $frequency->slug);
        self::assertSame('bar', $frequency->label);
        self::assertSame(2, $frequency->installments);
    }
}
