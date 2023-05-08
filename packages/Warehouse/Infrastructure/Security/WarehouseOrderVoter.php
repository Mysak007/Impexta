<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Infrastructure\Security;

use Impexta\User\Domain\Entity\AdminUser;
use Impexta\User\Domain\Enum\UserRole;
use Impexta\Warehouse\Domain\Entity\WarehouseOrder;
use LogicException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

final class WarehouseOrderVoter extends Voter
{
    public const VIEW = 'VIEW';
    public const CREATE = 'CREATE';
    public const UPDATE = 'UPDATE';

    private AccessDecisionManagerInterface $decisionManager;

    public function __construct(
        AccessDecisionManagerInterface $decisionManager
    ) {
        $this->decisionManager = $decisionManager;
    }

    /**
     * @param mixed $subject
     */
    protected function supports(string $attribute, $subject): bool
    {
        if (
            !$subject instanceof WarehouseOrder &&
            $subject !== WarehouseOrder::class
        ) {
            return false;
        }

        return in_array(
            $attribute,
            [
                self::VIEW,
                self::CREATE,
                self::UPDATE,
            ],
            true
        );
    }

    /**
     * @param mixed $subject
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof AdminUser) {
            return false;
        }

        if (!$this->decisionManager->decide($token, [UserRole::ROLE_ADMIN])) {
            return false;
        }

        switch ($attribute) {
            case self::VIEW:
            case self::CREATE:
            case self::UPDATE:
                return true;
        }

        throw new LogicException('This code should not be reache');
    }
}
