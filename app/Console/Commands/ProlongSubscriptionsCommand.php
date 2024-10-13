<?php

namespace App\Console\Commands;

use App\Repositories\Interfaces\{PaymentPeriodRepositoryInterface, SubscriptionRepositoryInterface};
use Carbon\Carbon;
use Illuminate\Console\Command;

class ProlongSubscriptionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:prolong';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prolong subscriptions before they expire.';

    /**
     * Execute the console command.
     *
     * @param SubscriptionRepositoryInterface $subscriptionRepository
     * @param PaymentPeriodRepositoryInterface $paymentPeriodRepository
     * @return int
     */
    public function handle(
        SubscriptionRepositoryInterface $subscriptionRepository,
        PaymentPeriodRepositoryInterface $paymentPeriodRepository
    ): int
    {
        $now = Carbon::now();
        $currentSubscriptions = $subscriptionRepository->getCurrentSubscriptions();
        $relevantSubscriptions = $currentSubscriptions->where('active_until', $now);

        foreach ($relevantSubscriptions as $subscription) {
            // Check if each user has the next subscription. If no we prolong his current one for him.
            $nextSubscription = $subscriptionRepository->getNextSubscriptionArrayByUserId($subscription->user_id);
            if (!$nextSubscription) {
                $prolongedSubscription = $subscription->clone([
                    'active_from',
                    'active_until',
                    'price'
                ]);

                $monthsNumberForNewSubscription = 1;
                if ($subscription->paymentPeriod->type === $paymentPeriodRepository->getTypeYear()) {
                    $monthsNumberForNewSubscription = 12;
                }

                $prolongedSubscription->active_from = $now;
                $prolongedSubscription->active_until = $now->clone()->addMonths($monthsNumberForNewSubscription);

                // Recalculate the price because monthly price per user for the pricing plan may be changed
                $price = $subscription->pricingPlan->monthly_price_per_user * $subscription->user_number * $monthsNumberForNewSubscription;
                if ($subscription->paymentPeriod->discount_percent > 0) {
                    $price = ($price * (100 - $subscription->paymentPeriod->discount_percent)) / 100;
                }
                $prolongedSubscription->price = $price;

                $prolongedSubscription->save();
            }
        }

        return Command::SUCCESS;
    }
}
