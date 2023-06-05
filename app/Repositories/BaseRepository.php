<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    /**
     * @param Model $model
     */
    public function __construct(protected Model $model)
    {
    }

    /**
     * @return Collection
     */
    public function index(): Collection
    {
        return $this->model->all();
    }

    /**
     * @return mixed
     */
    public function paginate(): mixed
    {
        return $this->model->paginate();
    }

    /**
     * @return mixed
     */
    public function first(): mixed
    {
        return $this->model->first();
    }

    /**
     * @param Model $model
     * @param array $params
     * @return bool
     */
    public function update(array $params, Model $model): bool
    {
        $this->model = $model;
        return $this->model->update($params);
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function create(array $params): mixed
    {
        return $this->model->create($params);
    }

    /**
     * @param Model $model
     * @return int
     */
    public function destroy(Model $model): int
    {
        $this->model = $model;
        return $this->model->delete();
    }
}

