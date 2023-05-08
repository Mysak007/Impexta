<?php

declare(strict_types=1);

namespace App\Eshop\Enum;

use Elao\Enum\AutoDiscoveredValuesTrait;
use Elao\Enum\ReadableEnum;

final class Country extends ReadableEnum
{
    use AutoDiscoveredValuesTrait;

    public const CZECHIA = 'CZECHIA';
    public const SLOVAKIA = 'SLOVAKIA';

    /**
     * @return array<string, string>
     */
    public static function readables(): array
    {
        return [
            self::CZECHIA => 'Česká republika',
            self::SLOVAKIA => 'Slovenská republika',
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function currencies(): array
    {
        return [
            self::CZECHIA => 'CZK',
            self::SLOVAKIA => 'EUR',
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function codes(): array
    {
        return [
            self::CZECHIA => 'CZ',
            self::SLOVAKIA => 'SK',
        ];
    }

    public static function getCurrency(Country $country): string
    {
        try {
            return self::currencies()[$country->getValue()];
        } catch (\Throwable $exception) {
            /** @var string $countryValue */
            $countryValue = $country->getValue();

            throw new CurrencyNotFoundException($countryValue);
        }
    }

    public static function getCode(Country $country): string
    {
        try {
            return self::codes()[$country->getValue()];
        } catch (\Throwable $exception) {
            /** @var string $countryValue */
            $countryValue = $country->getValue();

            throw new CountryCodeNotFoundException($countryValue);
        }
    }
}
