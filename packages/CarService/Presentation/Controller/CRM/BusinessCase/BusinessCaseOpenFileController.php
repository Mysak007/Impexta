<?php

declare(strict_types=1);

namespace Impexta\CarService\Presentation\Controller\CRM\BusinessCase;

use Impexta\CarService\Domain\Entity\BusinessCaseFile;
use League\Flysystem\FilesystemOperator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

final class BusinessCaseOpenFileController extends AbstractController
{
    private FilesystemOperator $businessCaseStorage;

    public function __construct(FilesystemOperator $businessCaseStorage)
    {
        $this->businessCaseStorage = $businessCaseStorage;
    }

    /**
     * @Route("/autoservis/{id}/stahnout/{file_id}", name="car_service_crm_car_service_download_file",
     *     requirements={"id"="\d+"})
     * @ParamConverter("businessCaseFile", options={"id" = "file_id"})
     */
    public function __invoke(BusinessCaseFile $businessCaseFile): Response
    {
        /** @var string $filename */
        $filename = $businessCaseFile->getFilename();
        $file = $this->businessCaseStorage->read($filename);
        $response = new Response($file);
        $disposition = HeaderUtils::makeDisposition(
            ResponseHeaderBag::DISPOSITION_INLINE,
            $filename
        );
        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }
}
