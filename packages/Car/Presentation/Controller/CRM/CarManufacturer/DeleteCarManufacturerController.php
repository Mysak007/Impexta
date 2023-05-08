<?php

declare(strict_types=1);

namespace Impexta\Car\Presentation\Controller\CRM\CarManufacturer;

use Impexta\Car\Domain\Entity\CarManufacturer;
use Impexta\Car\Infrastructure\Repository\CarManufacturerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

final class DeleteCarManufacturerController extends AbstractController
{
    private CarManufacturerRepository $carManufacturerRepository;

    public function __construct(
        CarManufacturerRepository $carManufacturerRepository
    ) {
        $this->carManufacturerRepository = $carManufacturerRepository;
    }

    /**
     * @Route("/automobily/vyrobce/{id}/smazat", name="car_crm_car_manufacturer_delete")
     */
    public function __invoke(CarManufacturer $carManufacturer): RedirectResponse
    {
        $this->carManufacturerRepository->removeAndSave($carManufacturer);
        $this->addFlash('warning', 'Výrobce byl odstraněn.');

        return $this->redirectToRoute('car_crm_car_manufacturer_list');
    }
}
