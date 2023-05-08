<?php

declare(strict_types=1);

namespace Impexta\Car\Infrastructure\Model;

use Impexta\Car\Domain\Entity\Car;
use Impexta\Car\Infrastructure\Repository\CarManufacturerRepository;
use Impexta\Car\Infrastructure\Repository\CarRepository;
use Impexta\Product\Presentation\Form\Model\FilterModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class FilterModelFactory
{
    private CarManufacturerRepository $carManufacturerRepository;
    private CarRepository $carRepository;

    public function __construct(
        CarManufacturerRepository $carManufacturerRepository,
        CarRepository $carRepository
    ) {
        $this->carManufacturerRepository = $carManufacturerRepository;
        $this->carRepository = $carRepository;
    }

    public function createFromSession(SessionInterface $session): FilterModel
    {
        $filterModel = FilterModel::createEmpty();
        $manufacturerId = $session->get('manufacturer');
        $model = $session->get('model');
        $yearOfManufacture = $session->get('yearOfManufacture');
        $engineCapacity = $session->get('engineCapacity');

        $filterModel->manufacturer = $manufacturerId ? $this->carManufacturerRepository->find($manufacturerId) : null;
        $filterModel->model = $model ? (string) $model : null;
        $filterModel->yearOfManufacture = $yearOfManufacture ? (int) $yearOfManufacture : null;
        $filterModel->engineCapacity = $engineCapacity ? (float) $engineCapacity : null;

        return $filterModel;
    }

    public function createFromRequest(Request $request): FilterModel
    {
        $filterModel = FilterModel::createEmpty();
        $manufacturerId = (int) $request->query->get('manufacturerId');
        $filterModel->manufacturer = $this->carManufacturerRepository->find($manufacturerId);
        $filterModel->model = (string) $request->query->get('model');
        $filterModel->yearOfManufacture = (int) $request->query->get('yearOfManufacture');
        $filterModel->engineCapacity = (float) $request->query->get('engineCapacity');

        return $filterModel;
    }

    /** @return array<string, array<float|int|string, float|int|string>> */
    public function prepareChoicesForForm(FilterModel $filterModel): array
    {
        $cars = $this->carRepository->findBy([
            'manufacturer' => $filterModel->manufacturer,
        ]);

        $models = array_map(static function (Car $car) {
            return $car->getModel();
        }, $cars);

        $cars = $this->carRepository->findBy([
            'manufacturer' => $filterModel->manufacturer,
            'model' => $filterModel->model,
        ]);

        $yearOfManufactures = array_map(static function (Car $car) {
            return $car->getYearOfManufacture();
        }, $cars);
        $yearOfManufactures = array_unique($yearOfManufactures);

        $cars = $this->carRepository->findBy([
            'manufacturer' => $filterModel->manufacturer,
            'model' => $filterModel->model,
            'yearOfManufacture' => $filterModel->yearOfManufacture,
        ]);

        $engineCapacities = array_map(static function (Car $car) {
            return $car->getEngineCapacity();
        }, $cars);
        $engineCapacities = array_unique($engineCapacities);

        return [
            'model' => array_combine($models, $models),
            'yearOfManufacture' => array_combine($yearOfManufactures, $yearOfManufactures),
            'engineCapacity' => array_combine($engineCapacities, $engineCapacities),
        ];
    }
}
