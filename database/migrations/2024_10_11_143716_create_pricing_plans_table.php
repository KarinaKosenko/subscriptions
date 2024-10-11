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
        Schema::create('pricing_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name')
                ->unique()
                ->comment('A name of the pricing plan');
            $table->unsignedDecimal('monthly_price_per_user', 10, 2)
                ->comment('Price for one user per one month');
            $table->unsignedBigInteger('currency_id')
                ->comment('FK for currencies.id');
            $table->unsignedTinyInteger('is_active')
                ->default(1)
                ->comment('Plan activity status');
            $table->timestamps();

            $table->comment('A list of available payment plans');

            $table->foreign('currency_id')
                ->references('id')
                ->on('currencies')
                ->onUpdate('restrict')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_plans');
    }
};
