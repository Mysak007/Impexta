<?php

declare(strict_types=1);

namespace Impexta\CarService\Presentation\Controller\CRM\BusinessCaseCommunication;

use Impexta\CarService\Domain\Entity\BusinessCase;
use Impexta\CarService\Domain\Entity\BusinessCaseCommunication;
use Impexta\CarService\Infrastructure\Mapper\BusinessCaseCommunicationMapper;
use Impexta\CarService\Infrastructure\Repository\BusinessCaseCommunicationRepository;
use Impexta\CarService\Presentation\Form\Model\BusinessCaseCommunicationModel;
use Impexta\CarService\Presentation\Form\Type\BusinessCaseCommunicationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** @SuppressWarnings("PHPMD.LongVariable") */
final class EditBusinessCaseCommunicationController extends AbstractController
{
    private BusinessCaseCommunicationRepository $businessCaseCommunicationRepository;
    private BusinessCaseCommunicationMapper $businessCaseCommunicationMapper;

    public function __construct(
        BusinessCaseCommunicationRepository $businessCaseCommunicationRepository,
        BusinessCaseCommunicationMapper $businessCaseCommunicationMapper
    ) {
        $this->businessCaseCommunicationRepository = $businessCaseCommunicationRepository;
        $this->businessCaseCommunicationMapper = $businessCaseCommunicationMapper;
    }

    /**
     * @Route("/autoservis/{id}/komunikace/{communication_id}/upravit",
     *     name="car_service_crm_car_service_communication_edit", requirements={"id"="\d+"})
     * @ParamConverter("businessCaseCommunication", options={"id" = "communication_id"})
     */
    public function __invoke(
        Request $request,
        BusinessCase $businessCase,
        BusinessCaseCommunication $businessCaseCommunication
    ): Response {
        $model = BusinessCaseCommunicationModel::createFromEntity($businessCaseCommunication);
        $form = $this->createForm(BusinessCaseCommunicationType::class, $model);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->businessCaseCommunicationMapper->mapFromModel($businessCaseCommunication, $model);
            $this->businessCaseCommunicationRepository->save($businessCaseCommunication);

            $this->addFlash('success', 'Zpráva byla upravena.');

            return $this->redirectToRoute(
                'car_service_crm_car_service_detail',
                [
                    'id' => $businessCase->getId(),
                ]
            );
        }

        return $this->render(
            '@carservice/CRM/business_case_communication/business_case_communication_edit.html.twig',
            [
                'form' => $form->createView(),
                'businessCase' => $businessCase,
                'communication' => $businessCaseCommunication,
            ]
        );
    }
}
