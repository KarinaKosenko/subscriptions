<?php

namespace Database\Seeders;

use App\Models\{PaymentPeriod, PricingPlan, Subscription, User};
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $user = User::first();
        $pricingPlan = PricingPlan::where('name', 'Lite')->first();
        $paymentPeriod = PaymentPeriod::where('type', 'month')->first();

        if ($user && $pricingPlan && $paymentPeriod) {
            $activeUntil = Carbon
                ::createFromFormat('Y-m-d', '2024-10-20')
                ->startOfDay();

            $activeFrom = $activeUntil->clone()->subMonth();

            Subscription::create([
                'user_id' => $user->id,
                'pricing_plan_id' => $pricingPlan->id,
                'payment_period_id' => $paymentPeriod->id,
                'users_number' => 7,
                'price' => $pricingPlan->monthly_price_per_user * 7,
                'active_from' => $activeFrom->toDateTimeString(),
                'active_until' => $activeUntil->toDateTimeString(),
                'is_active' => 1
            ]);
        }
    }
}
