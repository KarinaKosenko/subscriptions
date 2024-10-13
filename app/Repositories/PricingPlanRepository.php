<?php

namespace App\Repositories;

use App\Models\PricingPlan;
use App\Repositories\Interfaces\PricingPlanRepositoryInterface;

class PricingPlanRepository extends BaseRepository implements PricingPlanRepositoryInterface
{
    /**
     * @param PricingPlan $model
     */
    public function __construct(PricingPlan $model)
    {
        parent::__construct($model);
    }

    /**
     * @return array
     */
    public function getOptionsArray(): array
    {
        $optionsArray = [];
        $pricingPlans = $this->model::active()->get();
        foreach ($pricingPlans as $plan) {
            $optionsArray[] = [
                'label' => $plan->name,
                'value' => $plan->id
            ];
        }

        return $optionsArray;
    }

    /**
     * @return array
     */
    public function getIdsArray(): array
    {
        return $this->model::active()->pluck('id')->toArray();
    }
}
