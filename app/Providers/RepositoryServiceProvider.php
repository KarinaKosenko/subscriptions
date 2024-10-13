<?php

namespace App\Providers;

use App\Repositories\Interfaces\{PaymentPeriodRepositoryInterface,
    PricingPlanRepositoryInterface,
    SubscriptionRepositoryInterface};
use App\Repositories\{PaymentPeriodRepository,
    PricingPlanRepository,
    SubscriptionRepository};
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(SubscriptionRepositoryInterface::class, SubscriptionRepository::class);
        $this->app->bind(PricingPlanRepositoryInterface::class, PricingPlanRepository::class);
        $this->app->bind(PaymentPeriodRepositoryInterface::class, PaymentPeriodRepository::class);
    }
}
