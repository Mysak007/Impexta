<?php

declare(strict_types=1);

namespace Impexta\User\Presentation\Controller\CRM\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

final class AdminUserLogoutController extends AbstractController
{
    /**
     * @Route("/odhlasit", name="user_crm_security_admin_user_logout")
     */
    public function __invoke(): void
    {
        // This method is responsible for logout user
    }
}
