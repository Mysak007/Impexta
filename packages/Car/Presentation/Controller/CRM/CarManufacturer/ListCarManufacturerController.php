<?php

declare(strict_types=1);

namespace Impexta\Car\Presentation\Controller\CRM\CarManufacturer;

use Impexta\Car\Infrastructure\Repository\CarManufacturerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ListCarManufacturerController extends AbstractController
{
    private CarManufacturerRepository $carManufacturerRepository;

    public function __construct(
        CarManufacturerRepository $carManufacturerRepository
    ) {
        $this->carManufacturerRepository = $carManufacturerRepository;
    }

    /**
     * @Route("/automobily/vyrobci", name="car_crm_car_manufacturer_list")
     */
    public function __invoke(): Response
    {
        return $this->render(
            '@car/CRM/car_manufacturer/car_manufacturer_list.html.twig',
            [
                'manufacturers' => $this->carManufacturerRepository->findAll(),
            ]
        );
    }
}
