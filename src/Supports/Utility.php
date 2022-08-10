<?php

namespace Laraflow\Core\Supports;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/**
 * Class Utility
 */
class Utility
{
    /**
     * Hash any text with laravel default has algo.
     * Currently, only support bcrypt() with cost 10
     *
     * @param  string  $password
     * @return string
     */
    public static function hashPassword(string $password): string
    {
        return Hash::make($password);
    }

    /*
     * Create a unique random username with given having input
     * As prefix text and a random number
     *
     * @param string $name
     * @param UserRepository|null $userRepository
     * @return string
     * @throws \Exception
     *
    public static function generateUsername(string $name, UserRepository $userRepository = null): string
    {
        if (is_null($userRepository)) {
            $userRepository = new UserRepository();
        }

        //removed white space from name
        $firstPart = preg_replace("([\s]+)", '-', Str::lower($name));

        //add a random number to end
        $username = trim($firstPart) . random_int(100, 1000);

        //verify generated username is unique
        return ($userRepository->verifyUniqueUsername($username)) ? $username : self::generateUsername($name, $userRepository);
    }
    */

    /**
     * Admin LTE 3 Supported Random Badge Colors
     *
     * @param  bool  $rounded
     * @return string
     */
    public static function randomBadgeBackground(bool $rounded = false): string
    {
        $class = '';

        $badges = [
            'bg-primary',
            'bg-secondary',
            'bg-success',
            'bg-danger',
            'bg-warning text-dark',
            'bg-info text-white',
            'bg-light text-dark',
            'bg-dark',
        ];

        if ($rounded) {
            $class .= 'rounded-pill ';
        }

        $class .= $badges[array_rand($badges)];

        return $class;
    }

    /**
     * Rename laravel log filename to more human readable format
     *
     * @param  string  $filename
     * @return array|string|string[]|null
     */
    public static function formatLogFilename(string $filename)
    {
        return preg_replace('/laravel\-([\d]{4})-([\d]{2})-([\d]{2})\.log/', '$3/$2/$1', $filename);
    }

    /**
     * @param  Model  $model
     * @return array
     */
    public static function modelAudits(Model $model): array
    {
        $auditCollection = [];

        $audits = $model->audits()->with('user')->latest()->get();

        foreach ($audits as $audit) {
            $auditCollection[Carbon::parse($audit->created_at)->format('Y-m-d')][] = $audit;
        }

        return $auditCollection;
    }

    /**
     * return a list of route names filtered with http verbs
     * [GET, POST, PUT, DELETE, etc]
     *
     * @param  string  $method
     * @return array
     */
    public static function routeNames(string $method = 'GET'): array
    {
        $routeCollection = Route::getRoutes()->getRoutesByMethod();

        $routes[$method] = [];

        if (isset($routeCollection[$method])) {
            foreach ($routeCollection[$method] as $route) {
                $routeName = $route->getName();
                if ($routeName === null) {
                    continue;
                }

                $routes[$method][$routeName] = self::permissionDisplay($routeName);
            }
        }

        return $routes;
    }

    /**
     * Convert Route Name Human Readable Style
     *
     * @param  string  $permission
     * @return string
     */
    public static function permissionDisplay(string $permission): string
    {
        return ucwords(str_replace(['.', '-', '_'], [' ', ' ', ' '], $permission));
    }
}
