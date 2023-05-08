<?php

declare(strict_types=1);

namespace Impexta\User\Presentation\Controller\CRM\ShopUser;

use Impexta\User\Domain\Entity\ShopUser;
use Impexta\User\Infrastructure\Repository\ShopUserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ShopUserDeleteController extends AbstractController
{
    private ShopUserRepository $shopUserRepository;

    public function __construct(
        ShopUserRepository $shopUserRepository
    ) {
        $this->shopUserRepository = $shopUserRepository;
    }

    /**
     * @Route("uzivatel/{id}/smazat", name="user_crm_shop_user_delete")
     */
    public function __invoke(ShopUser $shopUser): Response
    {
        $this->shopUserRepository->removeAndSave($shopUser);
        $this->addFlash('warning', 'Uživatel byl odstraněn.');

        return $this->redirectToRoute('user_crm_shop_user_list');
    }
}
