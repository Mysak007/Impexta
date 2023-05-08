<?php

declare(strict_types=1);

namespace Impexta\CarService\Domain\Factory;

use Impexta\CarService\Domain\Entity\BusinessCaseImage;
use Impexta\CarService\Domain\Entity\BusinessCaseInterface;
use Impexta\CarService\Presentation\Form\Model\BusinessCaseImageModel;

final class BusinessCaseImageFactory
{
    public function create(BusinessCaseImageModel $model, BusinessCaseInterface $businessCase): BusinessCaseImage
    {
        $image = new BusinessCaseImage($businessCase);
        $image->setFile($model->file);

        return $image;
    }
}
