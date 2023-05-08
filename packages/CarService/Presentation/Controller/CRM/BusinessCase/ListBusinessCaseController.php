<?php

declare(strict_types=1);

namespace Impexta\CarService\Presentation\Controller\CRM\BusinessCase;

use Impexta\CarService\Infrastructure\Repository\BusinessCaseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ListBusinessCaseController extends AbstractController
{
    private BusinessCaseRepository $businessCaseRepository;

    public function __construct(BusinessCaseRepository $businessCaseRepository)
    {
        $this->businessCaseRepository = $businessCaseRepository;
    }

    /**
     * @Route("/autoservis", name="car_service_crm_car_service_list")
     */
    public function __invoke(): Response
    {
        return $this->render(
            '@carservice/CRM/business_case/business_case_list.html.twig',
            [
                'business_cases' => $this->businessCaseRepository->findAll(),
            ]
        );
    }
}
