<?php

declare(strict_types=1);

namespace Impexta\User\Infrastructure\Security;

use Impexta\User\Domain\Entity\ShopUserInterface;
use Impexta\User\Infrastructure\Repository\ShopUserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

final class ShopUserLoginFormAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'user_eshop_security_shop_user_login';
    public const TARGET_ROUTE = 'user_eshop_shop_user_detail';

    private ShopUserRepository $shopUserRepository;
    private CsrfTokenManagerInterface $csrfTokenManager;
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(
        ShopUserRepository $shopUserRepository,
        UrlGeneratorInterface $urlGenerator,
        CsrfTokenManagerInterface $csrfTokenManager,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        parent::__construct($urlGenerator);

        $this->shopUserRepository = $shopUserRepository;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function supports(Request $request): bool
    {
        return $request->attributes->get('_route') === self::LOGIN_ROUTE
            && $request->isMethod('POST');
    }

    /**
     * @return array<string, string>
     */
    public function getCredentials(Request $request): array
    {
        $credentials = [
            'email' => $request->request->get('email'),
            'password' => $request->request->get('password'),
            'csrf_token' => $request->request->get('_csrf_token'),
        ];
        $request->getSession()->set(
            Security::LAST_USERNAME,
            $credentials['email']
        );

        return $credentials;
    }

    /**
     * @param mixed $credentials
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function getUser($credentials, UserProviderInterface $userProvider): ?ShopUserInterface
    {
        $token = new CsrfToken('authenticate', $credentials['csrf_token']);

        if (!$this->csrfTokenManager->isTokenValid($token)) {
            throw new InvalidCsrfTokenException();
        }

        $user = $this->shopUserRepository->findOneBy([
            'email' => $credentials['email'],
            'enabled' => true,
        ]);

        if (!$user) {
            throw new CustomUserMessageAuthenticationException('Kombinace jména a hesla je neplatná.');
        }

        return $user;
    }

    /**
     * @param mixed $credentials
     */
    public function checkCredentials($credentials, UserInterface $user): bool
    {
        return $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
    }

    public function getLoginRoute(): string
    {
        return self::LOGIN_ROUTE;
    }

    public function getTargetRoute(): string
    {
        return self::TARGET_ROUTE;
    }
}
