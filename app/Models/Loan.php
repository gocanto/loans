<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    public const DEFAULT_FREQUENCY = 'weekly';

    public const TERMS = [
        '3-months' => '3 Months',
    ];

    public const DEFAULT_TERM = '3-months';

}
