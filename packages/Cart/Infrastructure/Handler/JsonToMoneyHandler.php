<?php

declare(strict_types=1);

namespace Impexta\Cart\Infrastructure\Handler;

use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigatorInterface;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonDeserializationVisitor;
use Money\Currency;
use Money\Money;

final class JsonToMoneyHandler implements SubscribingHandlerInterface
{
    private const FORMAT = 'json';

    /**
     * @return array<int, array<string, int|string>>
     */
    public static function getSubscribingMethods(): array
    {
        return [
            [
                'direction' => GraphNavigatorInterface::DIRECTION_DESERIALIZATION,
                'format' => self::FORMAT,
                'type' => Money::class,
                'method' => 'deserializeMoneyFromJson',
            ],
        ];
    }

    /**
     * @param mixed $value
     * @param array<string, mixed> $type
     * @return string|Money
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function deserializeMoneyFromJson(
        JsonDeserializationVisitor $visitor,
        $value,
        array $type,
        Context $context
    ) {
        return new Money($value['amount'], new Currency($value['currency']['code']));
    }
}
