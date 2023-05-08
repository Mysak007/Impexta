<?php

declare(strict_types=1);

namespace Impexta\CarService\Presentation\Controller\CRM\BusinessCase;

use Impexta\CarService\Domain\Factory\BusinessCaseFactory;
use Impexta\CarService\Infrastructure\Repository\BusinessCaseRepository;
use Impexta\CarService\Presentation\Form\Model\BusinessCaseModel;
use Impexta\CarService\Presentation\Form\Type\BusinessCaseType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CreateBusinessCaseController extends AbstractController
{
    private BusinessCaseRepository $businessCaseRepository;
    private BusinessCaseFactory $businessCaseFactory;

    public function __construct(
        BusinessCaseRepository $businessCaseRepository,
        BusinessCaseFactory $businessCaseFactory
    ) {
        $this->businessCaseRepository = $businessCaseRepository;
        $this->businessCaseFactory = $businessCaseFactory;
    }

    /**
     * @Route("/autoservis/vytvorit", name="car_service_crm_car_service_create")
     */
    public function __invoke(Request $request): Response
    {
        $businessCaseModel = BusinessCaseModel::createEmpty();
        $form = $this->createForm(BusinessCaseType::class, $businessCaseModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $businessCase = $this->businessCaseFactory->create($businessCaseModel);

            $this->businessCaseRepository->save($businessCase);
            $this->addFlash('success', 'Servisní požadavek byl vytvořen.');

            return $this->redirectToRoute('car_service_crm_car_service_list');
        }

        return $this->render(
            '@carservice/CRM/business_case/business_case_create.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
