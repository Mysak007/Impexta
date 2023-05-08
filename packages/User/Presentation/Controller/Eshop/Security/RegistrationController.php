<?php

declare(strict_types=1);

namespace Impexta\User\Presentation\Controller\Eshop\Security;

use Impexta\User\Domain\Factory\ShopUserFactory;
use Impexta\User\Infrastructure\Repository\ShopUserRepository;
use Impexta\User\Presentation\Form\Model\ShopUserModel;
use Impexta\User\Presentation\Form\Type\ShopUserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class RegistrationController extends AbstractController
{
    private ShopUserFactory $userFactory;
    private ShopUserRepository $userRepository;

    public function __construct(
        ShopUserFactory $userFactory,
        ShopUserRepository $userRepository
    ) {
        $this->userFactory = $userFactory;
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/registrace", name="user_eshop_security_shop_user_registration")
     */
    public function __invoke(Request $request): Response
    {
        $shopUserModel = ShopUserModel::createEmpty();
        $form = $this->createForm(ShopUserType::class, $shopUserModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->userFactory->create($shopUserModel);
            $this->userRepository->save($user);
            $this->addFlash(
                'success',
                'Registrace byla dokončena. Prosím přejděte do emailu a klikněte na aktivační odkaz.'
            );

            return $this->redirectToRoute('user_eshop_security_shop_user_login');
        }

        return $this->render(
            '@user/Eshop/Security/shop_user_register.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
