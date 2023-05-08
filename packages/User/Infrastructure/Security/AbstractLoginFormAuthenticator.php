<?php

declare(strict_types=1);

namespace Impexta\User\Infrastructure\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator as SymfonyFormLoginAuthenticator;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

abstract class AbstractLoginFormAuthenticator extends SymfonyFormLoginAuthenticator implements LoginFormAuthenticatorInterface
{
    use TargetPathTrait;

    private UrlGeneratorInterface $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function onAuthenticationSuccess(
        Request $request,
        TokenInterface $token,
        string $providerKey
    ): RedirectResponse {
        $targetPath = $this->getTargetPath($request->getSession(), $providerKey);

        if ($targetPath) {
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse($this->urlGenerator->generate($this->getTargetRoute()));
    }

    protected function getLoginUrl(): string
    {
        return $this->urlGenerator->generate($this->getLoginRoute());
    }
}
