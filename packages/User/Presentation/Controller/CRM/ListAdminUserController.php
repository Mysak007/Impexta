<?php

declare(strict_types=1);

namespace Impexta\User\Presentation\Controller\CRM;

use Impexta\User\Domain\Entity\AdminUserInterface;
use Impexta\User\Domain\Enum\UserRole;
use Impexta\User\Infrastructure\Repository\AdminUserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ListAdminUserController extends AbstractController
{
    private AdminUserRepository $adminUserRepository;

    public function __construct(
        AdminUserRepository $adminUserRepository
    ) {
        $this->adminUserRepository = $adminUserRepository;
    }

    /**
     * @Route("administratori", name="user_crm_admin_user_list")
     */
    public function __invoke(): Response
    {
        $adminUsers = $this->adminUserRepository->findAll();

        return $this->render(
            '@user/CRM/user_admin_list.html.twig',
            [
                'admins' => $adminUsers,
                'user_class' => AdminUserInterface::class,
                'userEnum' => UserRole::class,
            ]
        );
    }
}
