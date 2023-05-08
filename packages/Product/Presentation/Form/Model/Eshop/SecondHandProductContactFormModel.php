<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Form\Model\Eshop;

use Symfony\Component\Validator\Constraints as Assert;

final class SecondHandProductContactFormModel
{
    /** @Assert\NotBlank(message="Email musí být vyplněn.") */
    public string $email;

    /** @Assert\NotBlank(message="Text emailu nesmí být prázdný.") */
    public string $text;
}
