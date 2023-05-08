<?php

declare(strict_types=1);

namespace Impexta\Car\Presentation\Controller\CRM\CarManufacturer;

use Impexta\Car\Domain\Factory\CarManufacturerFactory;
use Impexta\Car\Infrastructure\Repository\CarManufacturerRepository;
use Impexta\Car\Presentation\Form\Model\CarManufacturerModel;
use Impexta\Car\Presentation\Form\Type\CarManufacturerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CreateCarManufacturerController extends AbstractController
{
    private CarManufacturerRepository $carManufacturerRepository;
    private CarManufacturerFactory $carManufacturerFactory;

    public function __construct(
        CarManufacturerRepository $carManufacturerRepository,
        CarManufacturerFactory $carManufacturerFactory
    ) {
        $this->carManufacturerRepository = $carManufacturerRepository;
        $this->carManufacturerFactory = $carManufacturerFactory;
    }

    /**
     * @Route("/automobily/vyrobce/vytvorit", name="car_crm_car_manufacturer_create")
     */
    public function __invoke(Request $request): Response
    {
        $carManufacturerModel = CarManufacturerModel::createEmpty();
        $form = $this->createForm(CarManufacturerType::class, $carManufacturerModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carManufacturer = $this->carManufacturerFactory->createFromModel($carManufacturerModel);
            $this->carManufacturerRepository->save($carManufacturer);
            $this->addFlash('success', 'Výrobce byl vytvořen.');

            return $this->redirectToRoute('car_crm_car_manufacturer_list');
        }

        return $this->render(
            '@car/CRM/car_manufacturer/car_manufacturer_create.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
