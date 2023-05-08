<?php

declare(strict_types=1);

namespace Impexta\User\Presentation\Controller\CRM;

use Impexta\User\Domain\Entity\AdminUser;
use Impexta\User\Domain\Enum\UserRole;
use Impexta\User\Infrastructure\Security\AdminUserCrudVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DetailAdminUserController extends AbstractController
{
    /**
     * @Route("administrator/{id}", name="user_crm_admin_user_detail")
     */
    public function __invoke(AdminUser $adminUser): Response
    {
        $this->denyAccessUnlessGranted(AdminUserCrudVoter::VIEW, $adminUser);

        return $this->render('@user/CRM/user_admin_detail.html.twig', [
            'admin' => $adminUser,
            'userEnum' => UserRole::class,
        ]);
    }
}
