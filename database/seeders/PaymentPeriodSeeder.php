<?php

namespace Database\Seeders;

use App\Models\PaymentPeriod;
use Illuminate\Database\Seeder;

class PaymentPeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        PaymentPeriod::insert([
            [
                'type' => 'month',
                'amount' => 1,
                'discount_percent' => 0
            ],
            [
                'type' => 'year',
                'amount' => 1,
                'discount_percent' => 20
            ]
        ]);
    }
}
