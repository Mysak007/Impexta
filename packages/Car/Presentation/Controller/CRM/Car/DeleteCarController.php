<?php

declare(strict_types=1);

namespace Impexta\Car\Presentation\Controller\CRM\Car;

use Impexta\Car\Domain\Entity\Car;
use Impexta\Car\Infrastructure\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

final class DeleteCarController extends AbstractController
{
    private CarRepository $carRepository;

    public function __construct(
        CarRepository $carRepository
    ) {
        $this->carRepository = $carRepository;
    }

    /**
     * @Route("/automobil/{id}/smazat", name="car_crm_car_delete")
     */
    public function __invoke(Car $car): RedirectResponse
    {
        $this->carRepository->removeAndSave($car);
        $this->addFlash('warning', 'Vozidlo bylo odstraněno.');

        return $this->redirectToRoute('car_crm_car_list');
    }
}
