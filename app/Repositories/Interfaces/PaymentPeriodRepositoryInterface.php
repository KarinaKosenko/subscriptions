<?php

namespace App\Repositories\Interfaces;

interface PaymentPeriodRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @return array
     */
    public function getOptionsArray(): array;

    /**
     * @return array
     */
    public function getIdsArray(): array;

    /**
     * @return mixed
     */
    public function getTypeYear(): mixed;
}
