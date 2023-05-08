<?php

declare(strict_types=1);

namespace Impexta\User\Infrastructure\Security;

use Impexta\User\Domain\Entity\AdminUser;
use Impexta\User\Domain\Entity\AdminUserInterface;
use LogicException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

use function in_array;

final class AdminUserCrudVoter extends Voter
{
    public const ACCESS = 'access';
    public const CREATE = 'create';
    public const VIEW = 'view';
    public const EDIT = 'edit';
    public const DELETE = 'delete';

    private function canWorkWithAdminUser(AdminUser $adminUser): bool
    {
        $role = $adminUser->getRoles();

        return !in_array('ROLE_SUPERADMIN', $role, true);
    }

    /**
     * @param mixed $subject
     */
    protected function supports(string $attribute, $subject): bool
    {
        if (!$subject instanceof AdminUser && $subject !== AdminUserInterface::class) {
            return false;
        }

        return in_array(
            $attribute,
            [
                self::CREATE,
                self::VIEW,
                self::EDIT,
                self::DELETE,
                self::ACCESS,
            ],
            true
        );
    }

    /**
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
            case self::CREATE:
                return true;

            case self::EDIT:
            case self::DELETE:
                return $this->canWorkWithAdminUser($subject);
        }

        throw new LogicException('This code should not be reached');
    }
}
