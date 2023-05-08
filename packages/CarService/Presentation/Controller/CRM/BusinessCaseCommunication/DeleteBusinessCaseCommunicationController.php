<?php

declare(strict_types=1);

namespace Impexta\CarService\Presentation\Controller\CRM\BusinessCaseCommunication;

use Impexta\CarService\Domain\Entity\BusinessCase;
use Impexta\CarService\Domain\Entity\BusinessCaseCommunication;
use Impexta\CarService\Infrastructure\Repository\BusinessCaseCommunicationRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

/** @SuppressWarnings("PHPMD.LongVariable") */
final class DeleteBusinessCaseCommunicationController extends AbstractController
{
    private BusinessCaseCommunicationRepository $businessCaseCommunicationRepository;

    public function __construct(BusinessCaseCommunicationRepository $businessCaseCommunicationRepository)
    {
        $this->businessCaseCommunicationRepository = $businessCaseCommunicationRepository;
    }

    /**
     * @Route("/autoservis/{id}/komunikace/{communication_id}/smazat",
     *     name="car_service_crm_car_service_communication_delete", requirements={"id"="\d+"})
     * @ParamConverter("businessCaseCommunication", options={"id" = "communication_id"})
     */
    public function __invoke(
        BusinessCase $businessCase,
        BusinessCaseCommunication $businessCaseCommunication
    ): RedirectResponse {
        $this->businessCaseCommunicationRepository->removeAndSave($businessCaseCommunication);
        $this->addFlash('warning', 'Zpráva byla odstraněna.');

        return $this->redirectToRoute(
            'car_service_crm_car_service_detail',
            [
                'id' => $businessCase->getId(),
            ]
        );
    }
}
