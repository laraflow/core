<?php

namespace Laraflow\Laraflow\Abstracts\Repository;

use BadMethodCallException;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Laraflow\Laraflow\Interfaces\RepositoryInterface;
use PDOException;

/**
 * Class EloquentRepository
 * @package Laraflow\Laraflow\Abstracts\Repository
 */
abstract class EloquentRepository implements RepositoryInterface
{
    /**
     * @var Model
     */
    public $model;

    /**
     * @var int number of items will be on pagination
     */
    public $itemsPerPage = 10;

    /**
     * Repository constructor.
     * Constructor to bind model to repo
     * @param Model $model
     * @param int $itemsPerPage
     */
    public function __construct($model, int $itemsPerPage = 10)
    {
        $this->setModel($model);
        $this->itemsPerPage = $itemsPerPage;
    }

    /**
     * Get the associated model
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Associated Dynamically  model
     * @param mixed $model
     * @return void
     */
    public function setModel($model)
    {
        if (is_string($model)) {
            $this->model = App::make($model);
        } elseif ($model instanceof Model) {
            $this->model = $model;
        } else {
            throw new \InvalidArgumentException('Eloquent Repository setModel() except instance of Illuminate\Database\Eloquent\Model or Namespace');
        }
    }

    /**
     * Get all instances of model
     *
     * @return Collection|Model[]
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * create a new record in the database
     *
     * @param array $data
     * @return mixed
     * @throws Exception
     */
    public function create(array $data)
    {
        try {
            $newModel = $this->model->create($data);
            $this->setModel($newModel);
            return $this->getModel();
        } catch (Exception $exception) {
            $this->handleException($exception);

            return null;
        }
    }

    /**
     * update record in the database
     *
     * @param array $data
     * @param string|int $id
     * @return bool
     * @throws Exception
     */
    public function update(array $data, $id): bool
    {
        try {
            $recordModel = $this->model->findOrFail($id);
            $this->setModel($recordModel);

            return $this->model->update($data);
        } catch (Exception $exception) {
            $this->handleException($exception);

            return false;
        }
    }

    /**
     * remove record from the database
     * @param string|int $id
     * @return bool
     */
    public function delete($id): bool
    {
        return (bool)$this->model->destroy($id);
    }

    /**
     * show the record with the given id
     * @param string|int $id
     * @param bool $purge
     * @return mixed
     * @throws Exception
     */
    public function show($id, bool $purge = false)
    {
        $newModel = null;

        try {
            if ($purge === true) {
                $newModel = $this->model->withTrashed()->findOrFail($id);
            } else {
                $newModel = $this->model->findOrFail($id);
            }
        } catch (ModelNotFoundException $exception) {
            $this->handleException($exception);
        } finally {
            return $newModel;
        }
    }

    /**
     * remove record from the database
     * @param string|int $id
     * @return bool
     */
    public function restore($id): bool
    {
        return (bool)$this->model->withTrashed()->find($id)->restore($id);
    }

    /**
     * @return mixed
     */
    public function getQueryBuilder()
    {
        return $this->model->newQuery();
    }

    /**
     * Handle All catch Exceptions
     *
     * @param mixed $exception
     * @throws Exception
     * @return void
     */
    public function handleException($exception)
    {
        Log::error("Query Exception: ");
        Log::error($exception->getMessage());
        //if application is on production keep silent
        if (App::environment('production')):
            Log::error($exception->getMessage());

        //Eloquent Model Exception
        elseif ($exception instanceof ModelNotFoundException):
            throw new ModelNotFoundException($exception->getMessage());

        //DB Error
        elseif ($exception instanceof PDOException):
            throw new PDOException($exception->getMessage());

        //Invalid magic method called
        elseif ($exception instanceof BadMethodCallException):
            throw new BadMethodCallException($exception->getMessage());

        //Through general Exception
        else:
            throw new Exception($exception->getMessage());
        endif;
    }
}
