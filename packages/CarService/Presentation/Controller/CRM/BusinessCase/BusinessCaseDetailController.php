<?php

declare(strict_types=1);

namespace Impexta\CarService\Presentation\Controller\CRM\BusinessCase;

use Impexta\CarService\Domain\Entity\BusinessCase;
use Impexta\CarService\Infrastructure\Mapper\BusinessCaseMapper;
use Impexta\CarService\Infrastructure\Repository\BusinessCaseCommunicationRepository;
use Impexta\CarService\Infrastructure\Repository\BusinessCaseRepository;
use Impexta\CarService\Presentation\Form\Model\BusinessCaseDetailModel;
use Impexta\CarService\Presentation\Form\Type\BusinessCaseDetailType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** @SuppressWarnings("PHPMD.LongVariable") */
final class BusinessCaseDetailController extends AbstractController
{
    private BusinessCaseMapper $businessCaseMapper;
    private BusinessCaseRepository $businessCaseRepository;
    private BusinessCaseCommunicationRepository $businessCaseCommunicationRepository;

    public function __construct(
        BusinessCaseMapper $businessCaseMapper,
        BusinessCaseRepository $businessCaseRepository,
        BusinessCaseCommunicationRepository $businessCaseCommunicationRepository
    ) {
        $this->businessCaseMapper = $businessCaseMapper;
        $this->businessCaseRepository = $businessCaseRepository;
        $this->businessCaseCommunicationRepository = $businessCaseCommunicationRepository;
    }

    /**
     * @Route("/autoservis/{id}", name="car_service_crm_car_service_detail", requirements={"id"="\d+"})
     */
    public function __invoke(Request $request, BusinessCase $businessCase): Response
    {
        $businessCaseDetailModel = BusinessCaseDetailModel::createFromEntity($businessCase);
        $form = $this->createForm(BusinessCaseDetailType::class, $businessCaseDetailModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->businessCaseMapper->mapFromDetailModel($businessCase, $businessCaseDetailModel);
            $this->businessCaseRepository->save($businessCase);

            $this->addFlash('success', 'Servisní požadavek byl upraven.');
        }

        return $this->render(
            '@carservice/CRM/business_case/business_case_detail.html.twig',
            [
                'business_case' => $businessCase,
                'form' => $form->createView(),
                'communications' => $this->businessCaseCommunicationRepository->findBy(
                    [
                        'businessCase' => $businessCase,
                    ]
                ),
            ]
        );
    }
}
