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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')
                ->comment('FK for users.id');
            $table->unsignedBigInteger('pricing_plan_id')
                ->comment('FK for pricing_plans.id');
            $table->unsignedBigInteger('payment_period_id')
                ->comment('FK for payment_periods.id');
            $table->unsignedBigInteger('users_number')
                ->comment('Number of users included into subscription');
            $table->unsignedDecimal('price', 10, 2)
                ->comment('Subscription price');
            $table->dateTime('active_from')
                ->comment('Datetime when subscription starts');
            $table->dateTime('active_until')
                ->comment('Datetime when subscription finishes');
            $table->unsignedTinyInteger('is_active')
                ->default(1)
                ->comment('Subscription activity status');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('pricing_plan_id')
                ->references('id')
                ->on('pricing_plans')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('payment_period_id')
                ->references('id')
                ->on('payment_periods')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->comment('Users subscriptions history');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
