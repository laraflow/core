<?php

namespace Laraflow\Core\Services\Utilities;

use Laraflow\Core\Abstracts\Service\Service;
use Laraflow\Core\Supports\Money;

/**
 * Class MoneyService
 * @package Laraflow\Core\Services\Utilities
 */
class MoneyService extends Service
{
    /**
     * Return all currency list available for number formatting
     *
     * @return array[]
     */
    public static function all()
    {
        return Money::$currency;
    }

    /**
     * Return Currency Formatted string from number
     *
     * @param mixed $amount
     * @param string $currency
     * @param bool $onlyCurrency
     * @return string|null
     */
    public static function format($amount = null, string $currency = Money::USD, bool $onlyCurrency = false)
    {
        $currencyConfig = self::get($currency);

        if ($currencyConfig == null) {
            $currencyConfig = self::get(Money::USD);
        }

        if (is_numeric($amount)) {
            $formattedAmount = number_format(
                $amount,
                $currencyConfig['precision'],
                $currencyConfig['decimal_mark'],
                $currencyConfig['thousands_separator']
            );

            $amount = ($onlyCurrency == true)
                ? $currency . ' ' . $formattedAmount
                : (($currencyConfig['symbol_first'] == true)
                    ? $currencyConfig['symbol'] . ' ' . $formattedAmount
                    : $formattedAmount . ' ' . $currencyConfig['symbol']);
        }

        return $amount;
    }

    /**
     * Return single currency
     *
     * @param string $name
     * @return array|null
     */
    public static function get(string $name)
    {
        return (Money::$currency[$name] ?? null);
    }
}
