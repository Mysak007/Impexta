<?php

declare(strict_types=1);

namespace Impexta\Car\Presentation\Controller\CRM\Car;

use Impexta\Car\Infrastructure\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ListCarController extends AbstractController
{
    private CarRepository $carRepository;

    public function __construct(
        CarRepository $carRepository
    ) {
        $this->carRepository = $carRepository;
    }

    /**
     * @Route("/automobily", name="car_crm_car_list")
     */
    public function __invoke(): Response
    {
        return $this->render(
            '@car/CRM/car/car_list.html.twig',
            [
                'cars' => $this->carRepository->findAll(),
            ]
        );
    }
}
