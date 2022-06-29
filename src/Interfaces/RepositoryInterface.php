<?php

namespace Laraflow\Laraflow\Interfaces;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    /**
     * Get all instances of model
     *
     * @return Collection|Model[]
     */
    public function all();

    /**
     * create a new record in the database
     *
     * @param array $data
     * @return mixed
     * @throws Exception
     */
    public function create(array $data);

    /**
     * update record in the database
     *
     * @param array $data
     * @param string|int $id
     * @return bool
     */
    public function update(array $data, $id): bool;

    /**
     * remove record from the database
     * @param string|int $id
     * @return bool
     */
    public function delete($id): bool;

    /**
     * show the record with the given id
     * @param string|int $id
     * @param bool $purge
     * @return mixed
     * @throws Exception
     */
    public function show($id, bool $purge = false);

    /**
     * Get the associated model
     * @return mixed
     */
    public function getModel();

    /**
     * Associated Dynamically  model
     * @param mixed $model
     * @return void
     */
    public function setModel($model);

    /**
     * Eager load database relationships
     *
     * @param string|array $relations
     * @return Builder
     */
    public function with($relations): Builder;

    /**
     * @return mixed
     */
    public function getQueryBuilder();

    /**
     * Get the first Model meet this criteria
     *
     * @param string $column
     * @param string $operator
     * @param mixed $value
     * @return Model|null
     * @throws Exception
     */
    public function findFirstWhere(string $column, string $operator, $value): ?Model;

    /**
     * Get the all Model Columns Collection
     *
     * @param string $column
     * @return mixed
     * @throws Exception
     */
    public function findColumn(string $column);

    /**
     * Handle All catch Exceptions
     *
     * @param mixed $exception
     * @throws Exception
     */
    public function handleException($exception);

    /**
     * Restore any Soft-Deleted Table Row/Model
     * @param string|int $id
     * @return bool
     */
    public function restore($id): bool;

    /**
     * Return Query Builder with condition options
     *
     * @param array $conditions
     * @return mixed
     */
    public function filter(array $conditions = []);
}
