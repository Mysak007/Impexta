<?php

declare(strict_types=1);

namespace Impexta\Car\Presentation\Controller\CRM\CarManufacturer;

use Impexta\Car\Domain\Entity\CarManufacturer;
use Impexta\Car\Infrastructure\Repository\CarManufacturerRepository;
use Impexta\Car\Presentation\Form\Model\CarManufacturerModel;
use Impexta\Car\Presentation\Form\Type\CarManufacturerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class EditCarManufacturerController extends AbstractController
{
    private CarManufacturerRepository $carManufacturerRepository;

    public function __construct(
        CarManufacturerRepository $carManufacturerRepository
    ) {
        $this->carManufacturerRepository = $carManufacturerRepository;
    }

    /**
     * @Route("/automobily/vyrobce/{id}/upravit", name="car_crm_car_manufacturer_edit")
     */
    public function __invoke(CarManufacturer $carManufacturer, Request $request): Response
    {
        $carManufacturerModel = CarManufacturerModel::createFromEntity($carManufacturer);
        $form = $this->createForm(CarManufacturerType::class, $carManufacturerModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carManufacturer->populateFromModel($carManufacturerModel);
            $this->carManufacturerRepository->save($carManufacturer);
            $this->addFlash('success', 'Výrobce byl upraven.');

            return $this->redirectToRoute('car_crm_car_manufacturer_list');
        }

        return $this->render(
            '@car/CRM/car_manufacturer/car_manufacturer_edit.html.twig',
            [
                'form' => $form->createView(),
                'manufacturer' => $carManufacturer,
            ]
        );
    }
}
