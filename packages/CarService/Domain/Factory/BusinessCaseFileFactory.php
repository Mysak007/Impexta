<?php

declare(strict_types=1);

namespace Impexta\CarService\Domain\Factory;

use Impexta\CarService\Domain\Entity\BusinessCaseFile;
use Impexta\CarService\Domain\Entity\BusinessCaseInterface;
use Impexta\CarService\Presentation\Form\Model\BusinessCaseFileModel;

final class BusinessCaseFileFactory
{
    public function create(BusinessCaseFileModel $model, BusinessCaseInterface $businessCase): BusinessCaseFile
    {
        $file = new BusinessCaseFile($businessCase);
        $file->setFile($model->file);

        return $file;
    }
}
