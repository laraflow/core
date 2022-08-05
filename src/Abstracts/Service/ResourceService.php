<?php

namespace Laraflow\Core\Abstracts\Service;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

/**
 * Class ResourceService
 * @package Laraflow\Core\Abstracts\Service
 */
abstract class ResourceService extends Service
{
    /**
     * @var Model|mixed
     */
    public $model;

    /**
     * ResourceService constructor.
     * Constructor to bind model to repo
     *
     * @param mixed $model
     */
    public function __construct($model)
    {
        $this->setModel($model);
    }

    /**
     * Get the associated model
     *
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * Associated model class to service
     *
     * @param mixed $model
     * @return void
     */
    public function setModel($model)
    {
        if (is_string($model)) {
            $this->model = \App::make($model);
        } elseif ($model instanceof Model) {
            $this->model = $model;
        } else {
            throw new \InvalidArgumentException('setModel() except instance of Illuminate\Database\Eloquent\Model or Namespace');
        }
    }

    /**
     * Get all instances of model
     *
     * @param array $conditions
     * @return Collection|Model[]
     */
    public function index(array $conditions = [])
    {
        return $this->model->all();
    }

    /**
     * create a new record in the database
     *
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function create(array $data): ?Model
    {
        try {
            $newModel = $this->model->create($data);
            $this->setModel($newModel);

            return $this->getModel();
        } catch (\Exception $exception) {
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
     * @throws \Exception
     */
    public function update(array $data, $id): bool
    {
        try {
            $recordModel = $this->model->findOrFail($id);
            $this->setModel($recordModel);

            return $this->model->update($data);
        } catch (\Exception $exception) {
            $this->handleException($exception);

            return false;
        }
    }

    /**
     * show the record with the given id
     * @param string|int $id
     * @param bool $withTrashed
     * @return mixed
     * @throws \Exception
     */
    public function find($id, bool $withTrashed = false): ?Model
    {
        $newModel = null;

        try {
            if ($withTrashed === true) {
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
     * @param bool $hardDelete
     * @return bool
     */
    public function delete($id, $hardDelete = false): bool
    {
        if ($hardDelete == true) {
            return (bool)$this->model->forceDelete();
        }
        return (bool)$this->model->destroy($id);
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
     * Handle All catch Exceptions
     *
     * @param mixed $exception
     * @return void
     * @throws \Exception
     */
    public function handleException($exception)
    {
        Log::error("Query Exception->" . $exception->getMessage());

        //if application is on production keep silent
        if (App::environment('production')):
            Log::error($exception->getMessage());

        //Eloquent Model Exception
        elseif ($exception instanceof ModelNotFoundException):
            throw new ModelNotFoundException($exception->getMessage());

        //Database Exception
        elseif ($exception instanceof \PDOException):
            throw new \PDOException($exception->getMessage());

        //Invalid magic method called
        elseif ($exception instanceof \BadMethodCallException):
            throw new \BadMethodCallException($exception->getMessage());

        //Through general Exception
        else:
            throw new \Exception($exception->getMessage());
        endif;
    }

}
