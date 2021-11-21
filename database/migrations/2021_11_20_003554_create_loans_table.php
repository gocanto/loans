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
            $table->decimal('lent_amount', 19, 10);

            $table->unsignedTinyInteger('payment_installments');
            $table->string('payment_term')->default(Loan::defaultPaymentTerm());
            $table->string('payment_frequency')->default(Loan::defaultPaymentFrequency()->slug);

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
