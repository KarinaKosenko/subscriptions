<?php

namespace App\Repositories\Interfaces;

use Exception;

interface SubscriptionRepositoryInterface
{
    /**
     * @param int $userId
     * @return array
     */
    public function getCurrentSubscriptionArrayByUserId(int $userId): array;

    /**
     * @param int $userId
     * @return array|null[]
     */
    public function getNextSubscriptionArrayByUserId(int $userId): array;

    /**
     * @param int $userId
     * @param int $pricingPlanId
     * @param int $paymentPeriodId
     * @param int $usersNumber
     * @return mixed
     * @throws Exception
     */
    public function storeSubscriptionByUserId(int $userId, int $pricingPlanId, int $paymentPeriodId, int $usersNumber): mixed;

    /**
     * @return mixed
     */
    public function getCurrentSubscriptions(): mixed;
}
