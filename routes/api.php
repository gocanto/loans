<?php

declare(strict_types=1);

use App\Http\Controllers\LoansController;
use Illuminate\Support\Facades\Route;

Route::get('loans', [LoansController::class, 'handle']);
