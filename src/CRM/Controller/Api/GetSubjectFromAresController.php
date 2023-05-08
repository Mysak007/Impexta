<?php

declare(strict_types=1);

namespace App\CRM\Controller\Api;

use App\CRM\Ares\AresClient;
use holicz\SimpleException\BaseException;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class GetSubjectFromAresController extends AbstractController
{
    private AresClient $aresClient;
    private SerializerInterface $serializer;

    public function __construct(AresClient $aresClient, SerializerInterface $serializer)
    {
        $this->aresClient = $aresClient;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/ares/{identificationNumber}", methods={"GET"})
     */
    public function __invoke(int $identificationNumber): JsonResponse
    {
        try {
            $response = $this->aresClient->findByIdentificationNumber($identificationNumber);
            $response = $this->serializer->serialize($response, 'json');

            return new JsonResponse($response);
        } catch (BaseException $exception) {
            return new JsonResponse($exception->getPublicMessage(), $exception->getCode());
        }
    }
}
