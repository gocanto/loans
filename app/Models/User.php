<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as UserInterface;

/**
 * @property string $uuid
 * @property string $name
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @property Collection|Loan[] $loans
 * @property int $id
 */
class User extends UserInterface
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $casts = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }
}
