<?php

declare(strict_types=1);

namespace Impexta\CarService\Presentation\Form\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Impexta\CarService\Domain\Entity\BusinessCaseInterface;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;

final class BusinessCaseDetailModel implements ModelInterface
{
    /** @var ArrayCollection<int, BusinessCaseImageModel> $images */
    public Collection $images;

    /** @var ArrayCollection<int, BusinessCaseFileModel> $files */
    public Collection $files;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->files = new ArrayCollection();
    }

    /**
     * @param BusinessCaseInterface $businessCase
     */
    public static function createFromEntity(EntityInterface $businessCase): self
    {
        $businessCaseDetailModel = self::createEmpty();

        $images = [];

        foreach ($businessCase->getImages() as $image) {
            $images[] = BusinessCaseImageModel::createFromEntity($image);
        }

        $businessCaseDetailModel->images = new ArrayCollection($images);

        $files = [];

        foreach ($businessCase->getFiles() as $file) {
            $files[] = BusinessCaseFileModel::createFromEntity($file);
        }

        $businessCaseDetailModel->files = new ArrayCollection($files);

        return $businessCaseDetailModel;
    }

    public static function createEmpty(): self
    {
        return new self();
    }
}
