<?php

namespace Laraflow\Core\Interfaces;

use Exception;

interface ResourceServiceInterface
{
    /**
     * Get all instances of model
     *
     * @param array $conditions
     * @return mixed
     */
    public function index(array $conditions = []);

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
     * @param bool $hardDelete
     * @return bool
     */
    public function delete($id, $hardDelete = false): bool;

    /**
     * show the record with the given id
     * @param string|int $id
     * @param bool $withTrashed
     * @return mixed
     * @throws Exception
     */
    public function find($id, bool $withTrashed = false);

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
