<?php

declare(strict_types=1);

namespace Impexta\CarService\Presentation\Controller\CRM\BusinessCaseCommunication;

use Impexta\CarService\Domain\Entity\BusinessCase;
use Impexta\CarService\Domain\Factory\BusinessCaseCommunicationFactory;
use Impexta\CarService\Infrastructure\Repository\BusinessCaseCommunicationRepository;
use Impexta\CarService\Presentation\Form\Model\BusinessCaseCommunicationModel;
use Impexta\CarService\Presentation\Form\Type\BusinessCaseCommunicationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** @SuppressWarnings("PHPMD.LongVariable") */
final class CreateBusinessCaseCommunicationController extends AbstractController
{
    private BusinessCaseCommunicationFactory $businessCaseCommunicationFactory;
    private BusinessCaseCommunicationRepository $businessCaseCommunicationRepository;

    public function __construct(
        BusinessCaseCommunicationFactory $businessCaseCommunicationFactory,
        BusinessCaseCommunicationRepository $businessCaseCommunicationRepository
    ) {
        $this->businessCaseCommunicationFactory = $businessCaseCommunicationFactory;
        $this->businessCaseCommunicationRepository = $businessCaseCommunicationRepository;
    }

    /**
     * @Route("/autoservis/{id}/vytvorit-komunikaci", name="car_service_crm_car_service_communication_create",
     * requirements={"id"="\d+"})
     */
    public function __invoke(Request $request, BusinessCase $businessCase): Response
    {
        $model = BusinessCaseCommunicationModel::createEmpty();
        $form = $this->createForm(BusinessCaseCommunicationType::class, $model);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $businessCaseCommunication = $this->businessCaseCommunicationFactory->create($businessCase, $model);
            $this->businessCaseCommunicationRepository->save($businessCaseCommunication);

            $this->addFlash('success', 'Nová zpráva byla vytvořena.');

            return $this->redirectToRoute(
                'car_service_crm_car_service_detail',
                [
                    'id' => $businessCase->getId(),
                ]
            );
        }

        return $this->render(
            '@carservice/CRM/business_case_communication/business_case_communication_create.html.twig',
            [
                'form' => $form->createView(),
                'businessCase' => $businessCase,
            ]
        );
    }
}
