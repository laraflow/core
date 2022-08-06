<?php

namespace Laraflow\Core\Traits;

use App\Models\Backend\Setting\User;
use ErrorException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

trait BlamableTrait
{
    /**
     * check if the trait required config file is present
     *
     * @throws ErrorException
     */
    public static function checkConfig()
    {
        if (is_null(config('blameable'))) {
            if (App::environment('production')) {
                Log::error('Blameable Config is missing. please import config or fix model namespace');
            } else {
                throw new ErrorException('Blameable Config is missing. please import config or fix model namespace');
            }
        }
    }

    /**
     * load this event listener to class
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
            if (Auth::check()) {
                $user = Auth::user();
            } else {
                $userModel = config('blameable.models.user', User::class);
                $user = $userModel::where('email', 'admin@admin.com')->first();
            }
            $model->created_by = isset($user) ? $user->id : 1;
        });

        /**
         * Trigger Event and append updater id to model
         */
        static::updating(function (Model $model) {
            if (Auth::check()) {
                $user = Auth::user()->id;
            } else {
                $userModel = config('blameable.models.user', User::class);
                $user = $userModel::where('email', 'admin@admin.com')->first()->id;
            }
            $model->updated_by = isset($user) ? $user : 1;
        });

        /**
         * Trigger Event and append deleter id to model
         */
        static::deleting(function (Model $model) {
            if (Auth::check()) {
                $user = Auth::user()->id;
            } else {
                $userModel = config('blameable.models.user', User::class);
                $user = $userModel::where('email', 'admin@admin.com')->first()->id;
            }
            $model->deleted_by = isset($user) ? $user : 1;
        });
    }

    /**
     * if this model is created by a user
     *
     * @return BelongsTo
     * @throws ErrorException
     */
    public function createdBy(): BelongsTo
    {
        self::checkConfig();

        $userModel = config('blameable.models.user', User::class);
        return $this->belongsTo($userModel, config('blameable.columns.createdByAttribute', 'created_by'), config('blameable.foreign_id', 'id'));
    }

    /**
     * if this model is updated by a user
     *
     * @return BelongsTo
     * @throws ErrorException
     */
    public function updatedBy()
    {
        self::checkConfig();

        $userModel = config('blameable.models.user', User::class);
        return $this->belongsTo($userModel, config('blameable.columns.updatedByAttribute', 'updated_by'), config('blameable.foreign_id', 'id'));
    }

    /**
     * if this model is deleted by a user
     *
     * @return BelongsTo
     * @throws ErrorException
     */
    public function deletedBy()
    {
        self::checkConfig();

        $userModel = config('blameable.models.user', User::class);
        return $this->belongsTo($userModel, config('blameable.columns.deletedByAttribute', 'deleted_by'), config('blameable.foreign_id', 'id'));
    }
}
