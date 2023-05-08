<?php

declare(strict_types=1);

namespace Impexta\CarService\Presentation\Controller\CRM\BusinessCase;

use Impexta\CarService\Domain\Entity\BusinessCase;
use Impexta\CarService\Infrastructure\Mapper\BusinessCaseMapper;
use Impexta\CarService\Infrastructure\Repository\BusinessCaseRepository;
use Impexta\CarService\Presentation\Form\Model\BusinessCaseModel;
use Impexta\CarService\Presentation\Form\Type\BusinessCaseType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class EditBusinessCaseController extends AbstractController
{
    private BusinessCaseRepository $businessCaseRepository;
    private BusinessCaseMapper $businessCaseMapper;

    public function __construct(
        BusinessCaseRepository $businessCaseRepository,
        BusinessCaseMapper $businessCaseMapper
    ) {
        $this->businessCaseRepository = $businessCaseRepository;
        $this->businessCaseMapper = $businessCaseMapper;
    }

    /**
     * @Route("/autoservis/{id}/upravit", name="car_service_crm_car_service_edit", requirements={"id"="\d+"})
     */
    public function __invoke(Request $request, BusinessCase $businessCase): Response
    {
        $businessCaseModel = BusinessCaseModel::createFromEntity($businessCase);
        $form = $this->createForm(BusinessCaseType::class, $businessCaseModel, ['disabled_client' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->businessCaseMapper->mapFromModel($businessCase, $businessCaseModel);

            $this->businessCaseRepository->save($businessCase);
            $this->addFlash('success', 'Servisní požadavek byl upraven.');

            return $this->redirectToRoute(
                'car_service_crm_car_service_detail',
                [
                    'id' => $businessCase->getId(),
                ]
            );
        }

        return $this->render(
            '@carservice/CRM/business_case/business_case_edit.html.twig',
            [
                'form' => $form->createView(),
                'business_case' => $businessCase,
            ]
        );
    }
}
