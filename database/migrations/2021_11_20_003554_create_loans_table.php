<?php

declare(strict_types=1);

use App\Models\Loan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    public function up(): void
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->unsignedBigInteger('user_id');

            $table->string('description');
            $table->unsignedFloat('lent_amount');

            $table->string('payment_term')
                ->default(Loan::DEFAULT_TERM)
                ->comment('3, 6, 9, 12 months.');

            $table->string('payment_frequency')
                ->default(Loan::DEFAULT_FREQUENCY)
                ->comment('weekly, monthly, other'); //we assume weekly for now

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('loans', function (Blueprint $blueprint) {
            $blueprint->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
}
