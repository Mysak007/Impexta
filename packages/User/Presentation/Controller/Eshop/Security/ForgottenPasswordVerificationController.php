<?php

declare(strict_types=1);

namespace Impexta\User\Presentation\Controller\Eshop\Security;

use Impexta\User\Domain\Entity\ShopUser;
use Impexta\User\Infrastructure\Manager\ShopUserPasswordManager;
use Impexta\User\Infrastructure\Repository\ShopUserRepository;
use Impexta\User\Presentation\Form\Model\ShopUserPasswordModel;
use Impexta\User\Presentation\Form\Type\ShopUserPasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ForgottenPasswordVerificationController extends AbstractController
{
    private ShopUserPasswordManager $passwordManager;
    private ShopUserRepository $userRepository;

    public function __construct(
        ShopUserPasswordManager $passwordManager,
        ShopUserRepository $userRepository
    ) {
        $this->passwordManager = $passwordManager;
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/zapomenute-heslo/{token}", name="user_eshop_security_shop_user_forgotten_password_activation")
     */
    public function __invoke(ShopUser $user, Request $request): Response
    {
        $shopUserModel = ShopUserPasswordModel::createEmpty();
        $form = $this->createForm(ShopUserPasswordType::class, $shopUserModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->passwordManager->changeUserPassword($user, $shopUserModel);
            $this->userRepository->save($user);
            $this->addFlash('success', 'Vaše heslo bylo změněno. Nyní se můžete přihlásit.');

            return $this->redirectToRoute('user_eshop_security_shop_user_login');
        }

        return $this->render(
            '@user/Eshop/Security/shop_user_forgotten_password_verification.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
