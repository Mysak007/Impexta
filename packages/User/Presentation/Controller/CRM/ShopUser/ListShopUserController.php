<?php

declare(strict_types=1);

namespace Impexta\User\Presentation\Controller\CRM\ShopUser;

use Impexta\User\Domain\Entity\ShopUserInterface;
use Impexta\User\Infrastructure\Repository\ShopUserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ListShopUserController extends AbstractController
{
    private ShopUserRepository $shopUserRepository;

    public function __construct(
        ShopUserRepository $shopUserRepository
    ) {
        $this->shopUserRepository = $shopUserRepository;
    }

    /**
     * @Route("uzivatele", name="user_crm_shop_user_list")
     */
    public function __invoke(): Response
    {
        $shopUsers = $this->shopUserRepository->findAll();

        return $this->render(
            '@user/CRM/shopUser/shop_user_list.html.twig',
            [
                'shopUsers' => $shopUsers,
                'user_class' => ShopUserInterface::class,
            ]
        );
    }
}
