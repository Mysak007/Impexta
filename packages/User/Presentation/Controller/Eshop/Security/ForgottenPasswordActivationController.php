<?php

declare(strict_types=1);

namespace Impexta\User\Presentation\Controller\Eshop\Security;

use Impexta\User\Infrastructure\Repository\ShopUserRepository;
use Impexta\User\Presentation\Form\Model\ForgottenPasswordActivationModel;
use Impexta\User\Presentation\Form\Type\ForgottenPasswordActivationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ForgottenPasswordActivationController extends AbstractController
{
    private ShopUserRepository $userRepository;

    public function __construct(
        ShopUserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/zapomenute-heslo", name="user_eshop_security_shop_user_forgotten_password")
     */
    public function __invoke(Request $request): Response
    {
        $forgottenModel = ForgottenPasswordActivationModel::createEmpty();
        $form = $this->createForm(ForgottenPasswordActivationType::class, $forgottenModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->userRepository->findOneBy(["email" => $forgottenModel->email]);

            if ($user) {
                $user->refreshToken();
                $this->userRepository->save($user);

                $this->addFlash('success', 'Na e-mail jsme Vám odeslali instrukce pro obnovení hesla.');

                return $this->redirectToRoute('user_eshop_security_shop_user_login');
            }

            if ($user === null) {
                $this->addFlash('danger', 'Uvedený e-mail neexistuje');

                return $this->redirectToRoute('user_eshop_security_shop_user_forgotten_password');
            }
        }

        return $this->render(
            '@user/Eshop/Security/shop_user_forgotten_password.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
