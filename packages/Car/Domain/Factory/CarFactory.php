<?php

declare(strict_types=1);

namespace Impexta\Car\Domain\Factory;

use Impexta\Car\Domain\Entity\Car;
use Impexta\Car\Domain\Entity\CarInterface;
use Impexta\Car\Domain\Facade\CarManufacturerFacade;
use Impexta\Car\Presentation\Form\Model\CarModel;
use RuntimeException;

final class CarFactory
{
    private CarManufacturerFacade $carManufacturerFacade;

    public function __construct(
        CarManufacturerFacade $carManufacturerFacade
    ) {
        $this->carManufacturerFacade = $carManufacturerFacade;
    }

    /** @return array<int, CarInterface> */
    public function create(CarModel $carModel): array
    {
        $years = preg_split(CarModel::ESCAPE_NEW_LINE_REGEX, $carModel->yearOfManufacture);
        $engines = preg_split(CarModel::ESCAPE_NEW_LINE_REGEX, $carModel->engineCapacity);
        $manufacturer = $this->carManufacturerFacade->getCarManufacturerByName($carModel->manufacturer);

        if (!$years || !$engines) {
            throw new RuntimeException();
        }

        $cars = [];

        foreach ($years as $year) {
            foreach ($engines as $engine) {
                if (!is_numeric($engine)) {
                    $engine = $this->convertToNumeric($engine);
                }

                $car = new Car(
                    $manufacturer,
                    $carModel->category,
                    $carModel->model,
                    (int)$year,
                    (float)$engine,
                    $carModel->hideOnEshop
                );
                $cars[] = $car;
            }
        }

        return $cars;
    }

    private function convertToNumeric(string $engine): string
    {
        return str_replace(',', '.', $engine);
    }
}
