<?php

declare(strict_types=1);

namespace Impexta\Inquiry\Infrastructure\Email;

use Impexta\Inquiry\Domain\Entity\InquiryInterface;
use Microshop\SymfonySurvivalKit\Mailer\AbstractEmailMessage;
use Microshop\SymfonySurvivalKit\Mailer\AddressFactory;
use Ramsey\Uuid\UuidInterface;
use Symfony\Bridge\Twig\Mime\NotificationEmail;

use function Safe\sprintf;

final class InquiryEmailMessage extends AbstractEmailMessage
{
    private const BODY = 'Dobrý den, v příloze zasíláme Vaši poptávku, hezký den.';
    private const IMPORTANCE = NotificationEmail::IMPORTANCE_MEDIUM;
    private const SUBJECT = 'Vaše poptávka č. %s';

    public function __construct(InquiryInterface $inquiry, string $emailTo, string $attachment)
    {
        parent::__construct(
            AddressFactory::createFromString($emailTo),
            sprintf(self::SUBJECT, $inquiry->getId()),
            self::BODY,
            self::IMPORTANCE
        );

        $this->attach($attachment, 'Poptavka ' . $inquiry->getId() . '.pdf', 'application/pdf');
    }

    public function getHtmlTemplate(): string
    {
        return 'email/body.html.twig';
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
