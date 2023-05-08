<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Form\Model;

use Impexta\Product\Domain\Entity\SecondHandProductImageInterface;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @Vich\Uploadable
 */
final class SecondHandProductImageModel implements ModelInterface
{
    public bool $isMain;

    /** @Assert\Length(max="255", maxMessage="Maximální povolená délka je 255 znaků") */
    public ?string $filename = null;

    /**
     * @Vich\UploadableField(mapping="second_hand_product_image", fileNameProperty="filename")
     * @Assert\Image(maxSize="2048k")
     * @Assert\NotBlank(groups="create")
     */
    public ?File $file = null;

    /**
     * @param SecondHandProductImageInterface $entity
     * @return self
     */
    public static function createFromEntity(EntityInterface $entity): ModelInterface
    {
        $secondHandProductImage = new self();

        $secondHandProductImage->isMain = $entity->isMain();
        $secondHandProductImage->filename = $entity->getFilename();

        return $secondHandProductImage;
    }

    public static function createEmpty(): ModelInterface
    {
        return new self();
    }
}
