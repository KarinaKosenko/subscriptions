<?php

namespace App\Repositories;

use App\Models\Subscription;
use App\Repositories\Interfaces\{PaymentPeriodRepositoryInterface,
    PricingPlanRepositoryInterface,
    SubscriptionRepositoryInterface};
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\{DB, Log};
use Throwable;

class SubscriptionRepository implements SubscriptionRepositoryInterface
{
    /**
     * @param PaymentPeriodRepositoryInterface $paymentPeriodRepository
     * @param PricingPlanRepositoryInterface $pricingPlanRepository
     */
    public function __construct(
        private PaymentPeriodRepositoryInterface $paymentPeriodRepository,
        private PricingPlanRepositoryInterface $pricingPlanRepository
    )
    {}

    /**
     * @param int $userId
     * @return array|null[]
     */
    public function getCurrentSubscriptionArrayByUserId(int $userId): array
    {
        $subscription = $this->getCurrentSubscriptionByUserId($userId);
        if ($subscription) {
            return $this->returnFormattedSubscriptionArray($subscription);
        }

        return $this->returnEmptySubscription();
    }

    /**
     * @param int $userId
     * @return array|null[]
     */
    public function getNextSubscriptionArrayByUserId(int $userId): array
    {
        $subscription = Subscription::byUserId($userId)->future()->orderBy('active_from', 'asc')->first();
        if ($subscription) {
            return $this->returnFormattedSubscriptionArray($subscription);
        }

        return $this->returnEmptySubscription();
    }

    /**
     * @param int $userId
     * @param int $pricingPlanId
     * @param int $paymentPeriodId
     * @param int $usersNumber
     * @return mixed
     * @throws Exception
     */
    public function storeSubscriptionByUserId(int $userId, int $pricingPlanId, int $paymentPeriodId, int $usersNumber): mixed
    {
        $paymentPeriod = $this->paymentPeriodRepository->getById($paymentPeriodId);
        if (!$paymentPeriod) {
            throw new Exception('Payment period has not been found.');
        }

        $pricingPlan = $this->pricingPlanRepository->getById($pricingPlanId);
        if (!$pricingPlan) {
            throw new Exception('Pricing plan has not been found.');
        }

        $monthsNumberForNewSubscription = 1;
        if ($paymentPeriod->type === $this->paymentPeriodRepository->getTypeYear()) {
            $monthsNumberForNewSubscription = 12;
        }

        $price = $pricingPlan->monthly_price_per_user * $usersNumber * $monthsNumberForNewSubscription;
        if ($paymentPeriod->discount_percent > 0) {
            $price = ($price * (100 - $paymentPeriod->discount_percent)) / 100;
        }

        $activeFrom = Carbon::now()->toDateTimeString();
        $currentSubscription = $this->getCurrentSubscriptionByUserId($userId);
        if ($currentSubscription) {
            $activeFrom = $currentSubscription->active_until;
        }

        $activeUntil = Carbon::createFromFormat('Y-m-d H:i:s', $activeFrom)->addMonths($monthsNumberForNewSubscription);

        try {
            DB::beginTransaction();

            // Delete (softly) previously created user's future subscriptions if we have any
            Subscription::byUserId($userId)->future()->delete();

            $newSubscription = Subscription::create([
                'user_id' => $userId,
                'pricing_plan_id' => $pricingPlanId,
                'payment_period_id' => $paymentPeriodId,
                'users_number' => $usersNumber,
                'price' => $price,
                'active_from' => $activeFrom,
                'active_until' => $activeUntil,
                'is_active' => 1,
            ]);

            DB::commit();

            return $newSubscription;
        } catch (Throwable $e) {
            DB::rollback();
            Log::error('Subscription creation failed: ' . $e->getMessage());

            throw new Exception('Subscription creation failed.');
        }
    }

    /**
     * @return mixed
     */
    public function getCurrentSubscriptions(): mixed
    {
        return Subscription::current()->get();
    }

    /**
     * @param int $userId
     * @return ?Subscription
     */
    private function getCurrentSubscriptionByUserId(int $userId): ?Subscription
    {
        return Subscription::byUserId($userId)->current()->first();
    }

    /**
     * @param Subscription $subscription
     * @return array
     */
    private function returnFormattedSubscriptionArray(Subscription $subscription): array
    {
        return [
            'pricing_plan_id' => $subscription->pricingPlan->id,
            'pricing_plan_name' => $subscription->pricingPlan->name,
            'payment_period_id' => $subscription->paymentPeriod->id,
            'payment_period_type' => ucfirst($subscription->paymentPeriod->type),
            'monthly_price_per_user' => $subscription->pricingPlan->monthly_price_per_user,
            'currency' => $subscription->pricingPlan->currency->code,
            'users_number' => $subscription->users_number,
            'monthly_price' => $subscription->price,
            'active_from' => $this->formatSubscriptionDatetime($subscription->active_from),
            'active_until' => $this->formatSubscriptionDatetime($subscription->active_until)
        ];
    }

    /**
     * @return null[]
     */
    private function returnEmptySubscription(): array
    {
        return [
            'pricing_plan_id' => null,
            'pricing_plan_name' => null,
            'payment_period_id' => null,
            'payment_period_type' => null,
            'monthly_price_per_user' => null,
            'currency' => null,
            'users_number' => null,
            'monthly_price' => null,
            'active_from' => null,
            'active_until' => null,
        ];
    }

    /**
     * @param string $datetime
     * @param string $formatFrom
     * @param string $formatTo
     * @return string
     */
    private function formatSubscriptionDatetime(string $datetime, string $formatFrom = 'Y-m-d H:i:s', string $formatTo = 'd.m.Y H:i:s'): string
    {
        return Carbon::createFromFormat($formatFrom, $datetime)->format($formatTo);
    }
}
