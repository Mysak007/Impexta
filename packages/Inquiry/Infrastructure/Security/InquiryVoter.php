<?php

declare(strict_types=1);

namespace Impexta\Inquiry\Infrastructure\Security;

use Impexta\Inquiry\Domain\Entity\InquiryInterface;
use Impexta\User\Domain\Entity\AdminUser;
use Impexta\User\Domain\Enum\UserRole;
use LogicException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

use function in_array;

final class InquiryVoter extends Voter
{
    public const CAN_ASSIGN = 'can_assign';
    public const CAN_UNASSIGN = 'can_unassign';
    public const CAN_UPDATE = 'can_update';
    public const CAN_DELETE = 'can_delete';
    public const CAN_TRANSFER_TO_ORDER = 'can_transfer_to_order';
    public const CAN_SEND = 'can_send';

    /**
     * @param mixed $subject
     */
    protected function supports(string $attribute, $subject): bool
    {
        if (!$subject instanceof InquiryInterface) {
            return false;
        }

        return in_array(
            $attribute,
            [
                self::CAN_ASSIGN,
                self::CAN_UNASSIGN,
                self::CAN_UPDATE,
                self::CAN_DELETE,
                self::CAN_TRANSFER_TO_ORDER,
                self::CAN_SEND,
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
            case self::CAN_ASSIGN:
                return $subject->getAssignee() === null;

            case self::CAN_UNASSIGN:
                return $subject->getAssignee() === $user || $user->hasRole(UserRole::get(UserRole::ROLE_SUPERADMIN));

            case self::CAN_UPDATE:
            case self::CAN_DELETE:
            case self::CAN_TRANSFER_TO_ORDER:
            case self::CAN_SEND:
                return $subject->getAssignee() === $user;
        }

        throw new LogicException('This code should not be reached');
    }
}
