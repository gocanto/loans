<?php

declare(strict_types=1);

use App\Http\Controllers\Loans;
use App\Http\Controllers\Users;
use App\Http\Middleware\AdminUsersMiddleware;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => AdminUsersMiddleware::class,
    'prefix' => 'loans',
], static function (): void {
    Route::get('/', [Loans\IndexController::class, 'handle'])->name('loans.index');
    Route::get('users', [Loans\UsersController::class, 'handle'])->name('loans.users');
    Route::get('users/{uuid}', [Loans\UserLoansController::class, 'handle'])->name('loans.user.loan');
    Route::post('users/{uuid}', [Loans\StoreUserLoansController::class, 'handle'])->name('loans.store.user.loan');
});

Route::group([
    'prefix' => 'users',
], static function (): void {
    Route::get('{uuid}/loans', [Users\LoansController::class, 'handle'])->name('user.loans');
    Route::get('{userUuid}/loan/{loanUuid}', [Users\LoanController::class, 'handle'])->name('user.loan');
    Route::post('{uuid}/installments', [Users\InstallmentsController::class, 'handle'])->name('user.installments');
    Route::post('{userUuid}/installments/{installmentUuid}/paid', [Users\PayInstallmentController::class, 'handle'])->name('user.pay.installment');
});


