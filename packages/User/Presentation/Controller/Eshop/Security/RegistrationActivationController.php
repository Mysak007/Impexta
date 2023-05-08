<?php

declare(strict_types=1);

namespace Impexta\User\Presentation\Controller\Eshop\Security;

use Impexta\User\Infrastructure\Repository\ShopUserRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class RegistrationActivationController extends AbstractController
{
    private ShopUserRepository $userRepository;

    public function __construct(
        ShopUserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/registrace/{token}", name="user_eshop_security_shop_user_activation")
     */
    public function __invoke(string $token): Response
    {
        $dbToken = Uuid::fromString($token);
        $user = $this->userRepository->findOneBy(['token' => $dbToken]);

        if ($user) {
            $user->setEnabled(true);
            $user->setToken(null);
            $this->userRepository->save($user);
        }

        return $this->redirectToRoute('user_eshop_security_shop_user_login');
    }
}
