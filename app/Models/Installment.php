<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property Loan $loan
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @property Carbon $paid_at
 */
class Installment extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_id',
        'due_date',
        'due_amount',
        'paid_at',
    ];

    protected $casts = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class);
    }

    public function isPaid(): bool
    {
        return $this->paid_at !== null;
    }

    public function isPending(): bool
    {
        return !$this->isPaid();
    }
}
