<?php

declare(strict_types=1);

namespace Impexta\Car\Presentation\Controller\CRM\Car;

use Impexta\Car\Domain\Factory\CarFactory;
use Impexta\Car\Infrastructure\Repository\CarRepository;
use Impexta\Car\Presentation\Form\Model\CarModel;
use Impexta\Car\Presentation\Form\Type\CarType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CreateCarController extends AbstractController
{
    private CarRepository $carRepository;
    private CarFactory $carFactory;

    public function __construct(
        CarRepository $carRepository,
        CarFactory $carFactory
    ) {
        $this->carRepository = $carRepository;
        $this->carFactory = $carFactory;
    }

    /**
     * @Route("/automobil/vytvorit", name="car_crm_car_create")
     */
    public function __invoke(Request $request): Response
    {
        $carModel = CarModel::createEmpty();
        $form = $this->createForm(CarType::class, $carModel);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cars = $this->carFactory->create($carModel);

            foreach ($cars as $car) {
                $this->carRepository->persist($car);
            }

            $this->carRepository->flush();
            $this->addFlash('success', 'Vozidlo bylo vytvořeno.');

            return $this->redirectToRoute('car_crm_car_list');
        }

        return $this->render(
            '@car/CRM/car/car_create.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
