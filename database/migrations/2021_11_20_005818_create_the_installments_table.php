<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTheInstallmentsTable extends Migration
{
    public function up(): void
    {
        Schema::create('installments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->unsignedBigInteger('loan_id');
            $table->date('due_date');
            $table->decimal('due_amount', 19, 10);
            $table->timestamp('paid_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('installments', function (Blueprint $blueprint) {
            $blueprint->foreign('loan_id')->references('id')->on('loans');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('installments');
    }
}
