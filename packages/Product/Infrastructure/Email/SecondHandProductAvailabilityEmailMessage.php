<?php

declare(strict_types=1);

namespace Impexta\Product\Infrastructure\Email;

use Microshop\SymfonySurvivalKit\Mailer\AbstractEmailMessage;
use Microshop\SymfonySurvivalKit\Mailer\AddressFactory;
use Ramsey\Uuid\UuidInterface;
use Symfony\Bridge\Twig\Mime\NotificationEmail;

final class SecondHandProductAvailabilityEmailMessage extends AbstractEmailMessage
{
    private const IMPORTANCE = NotificationEmail::IMPORTANCE_MEDIUM;
    private const SUBJECT = 'Dotaz na bazarový produkt';
    private const RECIPIENT = 'store@example.com';

    public function __construct(
        string $text
    ) {
        $body = $text;

        parent::__construct(
            AddressFactory::createFromString(self::RECIPIENT),
            self::SUBJECT,
            $body,
            self::IMPORTANCE
        );
    }

    public function getActionText(): ?string
    {
        return null;
    }

    public function getActionPath(): ?string
    {
        return null;
    }

    /** @return array<string, int|UuidInterface|string> */
    public function getActionPathParameters(): array
    {
        return [];
    }
}
