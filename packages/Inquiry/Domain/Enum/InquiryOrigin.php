<?php

declare(strict_types=1);

namespace Impexta\Inquiry\Domain\Enum;

use Elao\Enum\AutoDiscoveredValuesTrait;
use Elao\Enum\ReadableEnum;

final class InquiryOrigin extends ReadableEnum
{
    use AutoDiscoveredValuesTrait;

    public const EMAIL = 'EMAIL';
    public const ESHOP = 'ESHOP';
    public const PHONE = 'PHONE';

    /**
     * @return array<string, string>
     */
    public static function readables(): array
    {
        return [
            self::EMAIL => 'E-mail',
            self::ESHOP => 'Eshop',
            self::PHONE => 'Telefon',
        ];
    }
}
