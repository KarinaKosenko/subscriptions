<?php

namespace App\Repositories\Interfaces;

interface BaseRepositoryInterface
{
    /**
     * @param int $id
     * @return mixed
     */
    public function getById(int $id): mixed;
}
