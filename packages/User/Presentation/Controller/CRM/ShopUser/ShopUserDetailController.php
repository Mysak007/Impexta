<?php

declare(strict_types=1);

namespace Impexta\User\Presentation\Controller\CRM\ShopUser;

use Impexta\User\Domain\Entity\ShopUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ShopUserDetailController extends AbstractController
{
    /**
     * @Route("uzivatel/{id}", name="user_crm_shop_user_detail")
     */
    public function __invoke(ShopUser $shopUser): Response
    {
        return $this->render('@user/CRM/shopUser/shop_user_detail.html.twig', [
            'shopUser' => $shopUser,
        ]);
    }
}
