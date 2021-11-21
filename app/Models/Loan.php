<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\Frequency;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;

/**
 * @property int $id
 * @property int $payment_installments
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
 * @method static create(array ...$attrs)
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
        'payment_installments',
    ];

    protected $casts = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

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

    public static function defaultPaymentTerm(): string
    {
        return 'fixed';
    }

    public static function paymentTerms(): array
    {
        return [
            'fixed' => 'Fixed Installments Amount',
        ];
    }

    public static function defaultPaymentFrequency(): Frequency
    {
        return Arr::get(self::paymentFrequencies(), 'weekly');
    }

    /**
     * @return array<string,Frequency>
     */
    public static function paymentFrequencies(): array
    {
        return [
            'weekly' => Frequency::make('weekly', 'Weekly', 4),
        ];
    }
}
