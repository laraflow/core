<?php

namespace Laraflow\Core\Traits;

use ErrorException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

trait BlameableTrait
{
    /**
     * check if the trait required config file is present
     *
     * @throws ErrorException
     */
    public static function checkConfig()
    {
        if (is_null(config('core.blame'))) {
            if (app()->environment('production')) {
                \Log::error('Blameable Config is missing. please import config or fix model namespace');
            } else {
                throw new ErrorException('Blameable Config is missing. please import config or fix model namespace');
            }
        }


    }

    /**
     * load this event listener to model
     *
     * @throws ErrorException
     */
    public static function bootBlamableTrait()
    {
        self::checkConfig();

        /**
         * Trigger Event and append creator id to model
         */
        static::creating(function (Model $model) {

            $modelCreatedByAttribute = config('core.blame.createdBy', 'created_by');

            $blameable_id = (auth()->check())
                ? auth()->user()->id
                : config('core.blame.user')::where('email', 'admin@admin.com')->first()->id;

            $model->$modelCreatedByAttribute = $blameable_id ?? null;

            $model->save();
        });

        /**
         * Trigger Event and append updater id to model
         */
        static::updating(function (Model $model) {

            $modelUpdatedByAttribute = config('core.blame.updatedBy', 'created_by');

            $blameable_id = (auth()->check())
                ? auth()->user()->id
                : config('core.blame.user')::where('email', 'admin@admin.com')->first()->id;

            $model->$modelUpdatedByAttribute = $blameable_id ?? null;

            $model->save();
        });

        /**
         * Trigger Event and append deleter id to model
         */
        if (static::usesSoftDelete()) {
            static::deleting(function (Model $model) {

                $modelDeletedByAttribute = config('core.blame.deletedBy', 'created_by');

                $blameable_id = (auth()->check())
                    ? auth()->user()->id
                    : config('core.blame.user')::where('email', 'admin@admin.com')->first()->id;

                $model->$modelDeletedByAttribute = $blameable_id ?? null;

                $model->save();
            });
        }
    }

    public static function checkBlameableColumns() {
        $table = (new static)->getTable();
        $createdByAttribute = config('core.blame.createdBy', 'created_by');
        $updatedByAttribute = config('core.blame.updatedBy', 'updated_by');
        $deletedByAttribute = config('core.blame.deletedBy', 'deleted_by');
        if (!Schema::hasColumn($table, $createdByAttribute)
            && !Schema::hasColumn($table, $updatedByAttribute)
            && !Schema::hasColumn($table, $deletedByAttribute)) {
            //
        }
    }

    public static function addBlameableColumns() {
        $table = (new static)->getTable();
        $createdByAttribute = config('core.blame.createdBy', 'created_by');
        $updatedByAttribute = config('core.blame.updatedBy', 'updated_by');
        $deletedByAttribute = config('core.blame.deletedBy', 'deleted_by');
        if (!Schema::hasColumn($table, $createdByAttribute)
            && !Schema::hasColumn($table, $updatedByAttribute)
            && !Schema::hasColumn($table, $deletedByAttribute)) {
            Schema::table($table, function (Blueprint $table) {
                $table->blameable();
            });
        }
    }

    /**
     * relation of model is created by a user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(
            config('core.blame.user'),
            config('core.blame.createdBy', 'created_by'),
            'id');
    }

    /**
     * if this model is updated by a user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function editor()
    {
        return $this->belongsTo(
            config('core.blame.user'),
            config('core.blame.updatedBy', 'updated_by'),
            'id');
    }

    /**
     * if this model is deleted by a user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deletor()
    {
        return $this->belongsTo(
            config('core.blame.user'),
            config('core.blame.deletedBy', 'deleted_by'),
            'id');
    }

    protected static function usesSoftDelete()
    {
        static $softDelete;

        if (is_null($softDelete)) {
            $instance = new static;
            return $softDelete = method_exists($instance, 'bootSoftDeletes');
        }

        return $softDelete;
    }

}
