<?php

declare(strict_types=1);

namespace Impexta\User\Presentation\Controller\CRM\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class AdminUserLoginController extends AbstractController
{
    /**
     * @Route("/prihlaseni", name="user_crm_security_admin_user_login")
     */
    public function __invoke(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            '@user/CRM/security/admin_user_login.html.twig',
            [
                'last_username' => $lastUsername,
                'error' => $error,
                'csrf_token' => true,
            ]
        );
    }
}
