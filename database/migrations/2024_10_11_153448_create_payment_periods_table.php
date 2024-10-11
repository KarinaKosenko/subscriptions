<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('payment_periods', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['month', 'year'])
                ->comment('Period type: month, year');
            $table->unsignedInteger('amount')
                ->default(1)
                ->comment('Period amount');
            $table->unsignedInteger('discount_percent')
                ->default(0)
                ->comment('Period discount, %');
            $table->timestamps();

            $table->comment('A list of available payment periods for pricing plans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_periods');
    }
};
