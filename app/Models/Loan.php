<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $uuid
 * @property string $description
 * @property string $payment_term
 * @property string $payment_frequency
 * @property float $lent_amount
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @property Collection|Installment[] $installments
 * @property User $user
 */
class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'user_id',
        'description',
        'lent_amount',
        'payment_term',
        'payment_frequency',
    ];

    protected $casts = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const DEFAULT_FREQUENCY = 'weekly';

    public const TERMS = [
        '3-months' => '3 Months',
    ];

    public const DEFAULT_TERM = '3-months';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function installments(): HasMany
    {
        return $this->hasMany(Installment::class);
    }

    public static function byUserUuidQuery(string $uuid): Builder
    {
        return self::query()
            ->whereHas('user', function (Builder $builder) use ($uuid): void {
                $builder->where('uuid', $uuid);
            });
    }
}
