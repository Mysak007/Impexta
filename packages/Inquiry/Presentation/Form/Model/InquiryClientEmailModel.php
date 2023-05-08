<?php

declare(strict_types=1);

namespace Impexta\Inquiry\Presentation\Form\Model;

use Impexta\Inquiry\Domain\Entity\InquiryInterface;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;

final class InquiryClientEmailModel implements ModelInterface
{
    public string $email;

    /** @param InquiryInterface $entity */
    public static function createFromEntity(EntityInterface $entity): self
    {
        $model = self::createEmpty();
        $model->email = $entity->getClient()->getContactDetails()->getEmail();

        return $model;
    }

    public static function createEmpty(): self
    {
        return new self();
    }
}
