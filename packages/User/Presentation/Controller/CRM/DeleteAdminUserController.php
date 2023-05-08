<?php

declare(strict_types=1);

namespace Impexta\User\Presentation\Controller\CRM;

use Impexta\User\Domain\Entity\AdminUser;
use Impexta\User\Infrastructure\Repository\AdminUserRepository;
use Impexta\User\Infrastructure\Security\AdminUserCrudVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DeleteAdminUserController extends AbstractController
{
    private AdminUserRepository $userRepository;

    public function __construct(
        AdminUserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("administrator/{id}/smazat", name="user_crm_admin_user_delete")
     */
    public function __invoke(AdminUser $adminUser): Response
    {
        $this->denyAccessUnlessGranted(AdminUserCrudVoter::DELETE, $adminUser);

        $this->userRepository->removeAndSave($adminUser);
        $this->addFlash('warning', 'Uživatel byl odstraněn.');

        return $this->redirectToRoute('user_crm_admin_user_list');
    }
}
