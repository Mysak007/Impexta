<?php

declare(strict_types=1);

namespace Impexta\User\Presentation\Controller\CRM\ShopUser;

use Impexta\User\Domain\Factory\ShopUserFactory;
use Impexta\User\Infrastructure\Repository\ShopUserRepository;
use Impexta\User\Presentation\Form\Model\ShopUserModel;
use Impexta\User\Presentation\Form\Type\ShopUserAdminType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CreateShopUserController extends AbstractController
{
    private ShopUserRepository $shopUserRepository;
    private ShopUserFactory $shopUserFactory;

    public function __construct(
        ShopUserRepository $shopUserRepository,
        ShopUserFactory $shopUserFactory
    ) {
        $this->shopUserRepository = $shopUserRepository;
        $this->shopUserFactory = $shopUserFactory;
    }

    /**
     * @Route("uzivatel/vytvorit", name="user_crm_shop_user_create")
     */
    public function __invoke(Request $request): Response
    {
        $model = ShopUserModel::createEmpty();
        $form = $this->createForm(ShopUserAdminType::class, $model, [
            'validation_groups' => [
                'Default',
                'registration',
            ],
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->shopUserFactory->create($model);

            $this->shopUserRepository->save($user);
            $this->addFlash('success', 'Uživatel byl vytvořen');

            $userId = $user->getId();

            return $this->redirectToRoute('user_crm_shop_user_detail', ['id' => $userId]);
        }

        return $this->render(
            '@user/CRM/shopUser/shop_user_create.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
