<?php

declare(strict_types=1);

namespace Impexta\CarService\Presentation\Form\Model;

use Impexta\CarService\Domain\Entity\BusinessCaseImageInterface;
use Impexta\CarService\Domain\Entity\BusinessCaseInterface;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @Vich\Uploadable
 */
final class BusinessCaseImageModel implements ModelInterface
{
    public BusinessCaseInterface $businessCase;

    /** @Assert\Length(max="255", maxMessage="Maximální povolená délka je 255 znaků") */
    public ?string $filename = null;

    /**
     * @Vich\UploadableField(mapping="business_case_image", fileNameProperty="filename")
     * @Assert\Image(maxSize="2048k")
     * @Assert\NotBlank(groups="create")
     */
    public ?File $file = null;

    /**
     * @param BusinessCaseImageInterface $businessCaseImage
     */
    public static function createFromEntity(EntityInterface $businessCaseImage): self
    {
        $businessCaseImageModel = self::createEmpty();
        $businessCaseImageModel->businessCase = $businessCaseImage->getBusinessCase();
        $businessCaseImageModel->filename = $businessCaseImage->getFilename();

        return $businessCaseImageModel;
    }

    public static function createEmpty(): self
    {
        return new self();
    }
}
