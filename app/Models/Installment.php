<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property Loan $loan
 * @property string $uuid
 * @property string $due_date
 * @property float $due_amount
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
        'uuid',
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

    public static function byUserAndLoanQuery(string $userUuid, string $loanUuid): Builder
    {
        return self::query()
            ->whereHas('loan', function (Builder $builder) use ($userUuid, $loanUuid) {
                $builder
                    ->where('uuid', $loanUuid)
                    ->whereHas('user', function (Builder $builder) use ($userUuid): void {
                        $builder->where('uuid', $userUuid);
                    });
            });
    }
}
