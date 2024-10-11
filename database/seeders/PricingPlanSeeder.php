<?php

namespace Database\Seeders;

use App\Models\{Currency, PricingPlan};
use Illuminate\Database\Seeder;

class PricingPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $currency = Currency::where('code', 'EUR')->first();
        if ($currency) {
            $currency->pricingPlans()->createMany([
                [
                    'name' => 'Lite',
                    'monthly_price_per_user' => 4
                ],
                [
                    'name' => 'Starter',
                    'monthly_price_per_user' => 6
                ],
                [
                    'name' => 'Premium',
                    'monthly_price_per_user' => 10
                ]
            ]);
        }
    }
}
