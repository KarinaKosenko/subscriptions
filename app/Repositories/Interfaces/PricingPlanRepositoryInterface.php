<?php

namespace App\Repositories\Interfaces;

interface PricingPlanRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @return array
     */
    public function getOptionsArray(): array;

    /**
     * @return array
     */
    public function getIdsArray(): array;
}
