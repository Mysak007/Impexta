<?php

declare(strict_types=1);

namespace Impexta\ContactForm\Infrastructure\Security;

use Impexta\ContactForm\Domain\Entity\ContactForm;
use Impexta\User\Domain\Entity\AdminUser;
use LogicException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

final class ContactFormVoter extends Voter
{
    public const ACCESS = 'access';
    public const VIEW = 'view';
    public const DELETE = 'delete';

    /**
     * @param mixed $subject
     */
    protected function supports(string $attribute, $subject): bool
    {
        if (!$subject instanceof ContactForm && $subject !== ContactForm::class) {
            return false;
        }

        return in_array(
            $attribute,
            [
                self::ACCESS,
                self::VIEW,
                self::DELETE,
            ],
            true
        );
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @param mixed $subject
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof AdminUser) {
            return false;
        }

        switch ($attribute) {
            case self::ACCESS:
            case self::VIEW:
            case self::DELETE:
                return true;
        }

        throw new LogicException('This code should not be reached');
    }
}
