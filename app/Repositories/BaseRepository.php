<?php

namespace App\Repositories;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements BaseRepositoryInterface
{
    /**
     * @param Model $model
     */
    public function __construct(protected Model $model)
    {}

    /**
     * @param int $id
     * @return mixed
     */
    public function getById(int $id): mixed
    {
        return $this->model::find($id);
    }
}
