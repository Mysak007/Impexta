<?php

declare(strict_types=1);

namespace Impexta\Car\Presentation\Controller\CRM\Car;

use Impexta\Car\Domain\Entity\Car;
use Impexta\Car\Domain\Facade\CarManufacturerFacade;
use Impexta\Car\Infrastructure\Repository\CarRepository;
use Impexta\Car\Presentation\Form\Model\CarModel;
use Impexta\Car\Presentation\Form\Type\CarType;
use Impexta\Client\Infrastructure\Repository\ClientCarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class EditCarController extends AbstractController
{
    private CarRepository $carRepository;
    private CarManufacturerFacade $carManufacturerFacade;
    private ClientCarRepository $clientCarRepository;

    public function __construct(
        CarRepository $carRepository,
        CarManufacturerFacade $carManufacturerFacade,
        ClientCarRepository $clientCarRepository
    ) {
        $this->carRepository = $carRepository;
        $this->carManufacturerFacade = $carManufacturerFacade;
        $this->clientCarRepository = $clientCarRepository;
    }

    /**
     * @Route("/automobil/{id}/upravit", name="car_crm_car_edit")
     */
    public function __invoke(Car $car, Request $request): Response
    {
        $carModel = CarModel::createFromEntity($car);
        $form = $this->createForm(CarType::class, $carModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manufacturer = $this->carManufacturerFacade->getCarManufacturerByName($carModel->manufacturer);
            $car->mapFromModel($carModel, $manufacturer);
            $this->carRepository->save($car);
            $this->addFlash('success', 'Vozidlo bylo upraveno.');

            return $this->redirectToRoute('car_crm_car_list');
        }

        $allowRemove = true;
        $clientCar = $this->clientCarRepository->findOneBy(['car' => $car]);

        if ($clientCar) {
            $allowRemove = false;
        }

        return $this->render(
            '@car/CRM/car/car_edit.html.twig',
            [
                'form' => $form->createView(),
                'car' => $car,
                'allow_remove' => $allowRemove,
            ]
        );
    }
}
