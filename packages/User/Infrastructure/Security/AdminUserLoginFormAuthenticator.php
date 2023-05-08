<?php

declare(strict_types=1);

namespace Impexta\User\Infrastructure\Security;

use Impexta\User\Domain\Entity\AdminUserInterface;
use Impexta\User\Infrastructure\Repository\AdminUserRepository;
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

final class AdminUserLoginFormAuthenticator extends AbstractLoginFormAuthenticator
{
    public const LOGIN_ROUTE = 'user_crm_security_admin_user_login';
    public const TARGET_ROUTE = 'crm_dashboard';

    private AdminUserRepository $adminUserRepository;
    private CsrfTokenManagerInterface $csrfTokenManager;
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(
        AdminUserRepository $adminUserRepository,
        UrlGeneratorInterface $urlGenerator,
        CsrfTokenManagerInterface $csrfTokenManager,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        parent::__construct($urlGenerator);

        $this->adminUserRepository = $adminUserRepository;
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
            'username' => $request->request->get('_username'),
            'password' => $request->request->get('_password'),
            'csrf_token' => $request->request->get('_csrf_token'),
        ];

        $request->getSession()->set(
            Security::LAST_USERNAME,
            $credentials['username']
        );

        return $credentials;
    }

    /**
     * @param array<string, string> $credentials
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function getUser($credentials, UserProviderInterface $userProvider): ?AdminUserInterface
    {
        $token = new CsrfToken('authenticate', $credentials['csrf_token']);

        if (!$this->csrfTokenManager->isTokenValid($token)) {
            throw new InvalidCsrfTokenException();
        }

        $user = $this->adminUserRepository->findOneBy([
            'username' => $credentials['username'],
            'enabled' => true,
        ]);

        if (!$user) {
            throw new CustomUserMessageAuthenticationException('Kombinace jména a hesla je neplatná.');
        }

        return $user;
    }

    /**
     * @param array<string, string> $credentials
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
