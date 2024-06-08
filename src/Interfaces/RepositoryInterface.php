<?php

namespace Laraflow\Core\Interfaces;

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
     * @return mixed
     *
     * @throws Exception
     */
    public function create(array $data);

    /**
     * update record in the database
     *
     * @param  string|int  $id
     */
    public function update(array $data, $id): bool;

    /**
     * remove record from the database
     *
     * @param  string|int  $id
     * @param  bool  $hardDelete
     */
    public function delete($id, $hardDelete = false): bool;

    /**
     * show the record with the given id
     *
     * @param  string|int  $id
     * @return mixed
     *
     * @throws Exception
     */
    public function find($id, bool $purge = false);

    /**
     * Get the associated model
     *
     * @return mixed
     */
    public function getModel();

    /**
     * Associated Dynamically  model
     *
     * @param  mixed  $model
     * @return void
     */
    public function setModel($model);

    /**
     * @return mixed
     */
    public function getQueryBuilder();

    /**
     * Handle All catch Exceptions
     *
     * @param  mixed  $exception
     *
     * @throws Exception
     */
    public function handleException($exception);

    /**
     * Restore any Soft-Deleted Table Row/Model
     *
     * @param  string|int  $id
     */
    public function restore($id): bool;

    /**
     * Return Query Builder with condition options
     *
     * @return mixed
     */
    public function filter(array $conditions = []);
}
