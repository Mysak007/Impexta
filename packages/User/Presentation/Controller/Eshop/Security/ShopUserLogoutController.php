<?php

declare(strict_types=1);

namespace Impexta\User\Presentation\Controller\Eshop\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

final class ShopUserLogoutController extends AbstractController
{
    /**
     * @Route("/odhlasit", name="user_eshop_security_shop_user_logout")
     */
    public function __invoke(): void
    {
        // This method is responsible for logout user
    }
}
