<?php

declare(strict_types=1);

namespace Impexta\User\Presentation\Controller\CRM\ShopUser;

use Impexta\User\Domain\Entity\ShopUser;
use Impexta\User\Infrastructure\Repository\ShopUserRepository;
use Impexta\User\Presentation\Form\Model\ShopUserModel;
use Impexta\User\Presentation\Form\Type\ShopUserAdminType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class ShopUserEditController extends AbstractController
{
    private ShopUserRepository $shopUserRepository;
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(
        ShopUserRepository $shopUserRepository,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $this->shopUserRepository = $shopUserRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("uzivatel/{id}/upravit", name="user_crm_shop_user_edit")
     */
    public function __invoke(ShopUser $shopUser, Request $request): Response
    {
        $model = ShopUserModel::createFromEntity($shopUser);

        $form = $this->createForm(ShopUserAdminType::class, $model, [
            'shopUser' => $shopUser,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($model->password->password) {
                $model->password->password = $this->passwordEncoder->encodePassword(
                    $shopUser,
                    $model->password->password
                );
            }

            $shopUser->mapFromShopUserModel($model);

            $this->shopUserRepository->save($shopUser);
            $this->addFlash('success', 'Uživatel byl aktualizovaný');

            $userId = $shopUser->getId();

            return $this->redirectToRoute('user_crm_shop_user_detail', ['id' => $userId]);
        }

        $canRemove = false;

        if (!$shopUser->getClient()) {
            $canRemove = true;
        }

        return $this->render(
            '@user/CRM/shopUser/shop_user_edit.html.twig',
            [
                'shopUser' => $shopUser,
                'form' => $form->createView(),
                'can_remove' => $canRemove,
            ]
        );
    }
}
