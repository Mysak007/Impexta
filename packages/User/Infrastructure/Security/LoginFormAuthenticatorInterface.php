<?php

declare(strict_types=1);

namespace Impexta\User\Infrastructure\Security;

interface LoginFormAuthenticatorInterface
{
    public function getTargetRoute(): string;

    public function getLoginRoute(): string;
}
