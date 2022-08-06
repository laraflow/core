<?php

namespace Laraflow\Core\Abstracts\Repository;

use BadMethodCallException;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Laraflow\Core\Interfaces\RepositoryInterface;
use PDOException;

/**
 * Class DBRepository
 */
abstract class DatabaseRepository implements RepositoryInterface
{
    /**
     * @var string name
     */
    public $model;

    /**
     * Repository constructor.
     * Constructor to bind model to repo
     *
     * @param string $model
     */
    public function __construct($model)
    {
        $this->setModel($model);
    }

    /**
     * Get the associated model
     *
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Associated Dynamically  model
     *
     * @param mixed $model
     * @return void
     */
    public function setModel($model)
    {
        if (is_string($model)) {
            $this->model = $model;
        } else {
            throw new InvalidArgumentException('Database Repository setModel() except string table name');
        }
    }

    /**
     * Get all instances of table rows
     *
     * @return Collection
     */
    public function all()
    {
        return $this->getQueryBuilder()->get();
    }

    /**
     * @return mixed
     */
    public function getQueryBuilder()
    {
        return DB::table($this->model);
    }

    /**
     * create a new record in the database
     *
     * @param array $data single model array
     * @return mixed
     *
     * @throws Exception
     */
    public function create(array $data)
    {
        try {
            $id = $this->getQueryBuilder()->insertGetId($data);

            return $this->find($id);
        } catch (Exception $exception) {
            $this->handleException($exception);

            return null;
        }
    }

    /**
     * show the record with the given id
     *
     * @param string|int $id
     * @param bool $purge
     * @return mixed
     *
     * @throws Exception
     */
    public function find($id, bool $purge = false)
    {
        $row = null;

        try {
            $row = $this->getQueryBuilder()
                ->where('id', '=', $id)
                ->where(function (Builder $subQuery) use ($purge) {
                    $q = $subQuery->whereNull('deleted_at');
                    if ($purge == true) {
                        $q->orWhereNotNull('deleted_at');
                    }
                })->first();
        } catch (ModelNotFoundException $exception) {
            $this->handleException($exception);
        } finally {
            return $row;
        }
    }

    /**
     * Handle All catch Exceptions
     *
     * @param mixed $exception
     * @return void
     *
     * @throws Exception
     */
    public function handleException($exception)
    {
        Log::error('Query Exception: ');
        Log::error($exception->getMessage());
        //if application is on production keep silent
        if (App::environment('production')) {
            Log::error($exception->getMessage());

            //Eloquent Model Exception
        } elseif ($exception instanceof ModelNotFoundException) {
            throw new ModelNotFoundException($exception->getMessage());
            //DB Error
        } elseif ($exception instanceof PDOException) {
            throw new PDOException($exception->getMessage());
            //Invalid magic method called
        } elseif ($exception instanceof BadMethodCallException) {
            throw new BadMethodCallException($exception->getMessage());
            //Through general Exception
        } else {
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * update record in the database
     *
     * @param array $data
     * @param string|int $id
     * @return bool
     *
     * @throws Exception
     */
    public function update(array $data, $id): bool
    {
        try {
            return (bool)$this->getQueryBuilder()
                ->where('id', '=', $id)
                ->update($data);
        } catch (Exception $exception) {
            $this->handleException($exception);

            return false;
        }
    }

    /**
     * remove record from the database
     *
     * @param string|int $id
     * @param bool $hardDelete
     * @return bool
     */
    public function delete($id, $hardDelete = false): bool
    {
        if ($hardDelete == true) {
            return (bool)$this->getQueryBuilder()
                ->where('id', '=', $id)
                ->delete();
        }

        return (bool)$this->getQueryBuilder()
            ->where('id', '=', $id)
            ->update(['deleted_at' => Carbon::now()]);
    }

    /**
     * remove record from the database
     *
     * @param string|int $id
     * @return bool
     */
    public function restore($id): bool
    {
        return (bool)$this->getQueryBuilder()
            ->where('id', '=', $id)
            ->update(['deleted_at' => null]);
    }
}
