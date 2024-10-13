<?php

namespace App\Repositories;

use App\Models\PaymentPeriod;
use App\Repositories\Interfaces\PaymentPeriodRepositoryInterface;

class PaymentPeriodRepository extends BaseRepository implements PaymentPeriodRepositoryInterface
{
    /**
     * @param PaymentPeriod $model
     */
    public function __construct(PaymentPeriod $model)
    {
        parent::__construct($model);
    }

    /**
     * @return array
     */
    public function getOptionsArray(): array
    {
        $optionsArray = [];
        $paymentPeriods = $this->model::all();
        foreach ($paymentPeriods as $period) {
            $optionsArray[] = [
                'label' => ucfirst($period->type),
                'value' => $period->id
            ];
        }

        return $optionsArray;
    }

    /**
     * @return array
     */
    public function getIdsArray(): array
    {
        return $this->model::pluck('id')->toArray();
    }

    /**
     * @return mixed
     */
    public function getTypeYear(): mixed
    {
        return $this->model::YEAR_TYPE;
    }
}
