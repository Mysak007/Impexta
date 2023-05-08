<?php

declare(strict_types=1);

namespace Impexta\CarService\Presentation\Controller\CRM\BusinessCase;

use Impexta\CarService\Domain\Entity\BusinessCase;
use Impexta\CarService\Infrastructure\Repository\BusinessCaseCommunicationRepository;
use Impexta\CarService\Infrastructure\Repository\BusinessCaseFileRepository;
use Impexta\CarService\Infrastructure\Repository\BusinessCaseImageRepository;
use Impexta\CarService\Infrastructure\Repository\BusinessCaseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

/** @SuppressWarnings("PHPMD.LongVariable") */
final class DeleteBusinessCaseController extends AbstractController
{
    private BusinessCaseRepository $businessCaseRepository;
    private BusinessCaseImageRepository $businessCaseImageRepository;
    private BusinessCaseFileRepository $businessCaseFileRepository;
    private BusinessCaseCommunicationRepository $businessCaseCommunicationRepository;

    public function __construct(
        BusinessCaseRepository $businessCaseRepository,
        BusinessCaseImageRepository $businessCaseImageRepository,
        BusinessCaseFileRepository $businessCaseFileRepository,
        BusinessCaseCommunicationRepository $businessCaseCommunicationRepository
    ) {
        $this->businessCaseRepository = $businessCaseRepository;
        $this->businessCaseImageRepository = $businessCaseImageRepository;
        $this->businessCaseFileRepository = $businessCaseFileRepository;
        $this->businessCaseCommunicationRepository = $businessCaseCommunicationRepository;
    }

    /**
     * @Route("/autoservis/{id}/smazat",
     *     name="car_service_crm_car_service_delete", requirements={"id"="\d+"})
     */
    public function __invoke(BusinessCase $businessCase): RedirectResponse
    {
        foreach ($businessCase->getImages() as $image) {
            $businessCase->removeImage($image);
            $this->businessCaseImageRepository->removeAndSave($image);
        }

        foreach ($businessCase->getFiles() as $file) {
            $businessCase->removeFile($file);
            $this->businessCaseFileRepository->removeAndSave($file);
        }

        $communications = $this->businessCaseCommunicationRepository->findBy(['businessCase' => $businessCase]);

        foreach ($communications as $communication) {
            $this->businessCaseCommunicationRepository->removeAndSave($communication);
        }

        $this->businessCaseRepository->removeAndSave($businessCase);
        $this->addFlash('warning', 'Servisní požadavek byl odstraněn.');

        return $this->redirectToRoute('car_service_crm_car_service_list');
    }
}
