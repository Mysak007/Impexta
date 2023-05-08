<?php

declare(strict_types=1);

namespace Impexta\Car\Api\Controller\Eshop;

use Impexta\Car\Infrastructure\Model\FilterModelFactory;
use Impexta\Car\Infrastructure\Repository\CarRepository;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CarFilterController extends AbstractController
{
    private SerializerInterface $serializer;
    private CarRepository $carRepository;
    private FilterModelFactory $filterModelFactory;

    public function __construct(
        SerializerInterface $serializer,
        CarRepository $carRepository,
        FilterModelFactory $filterModelFactory
    ) {
        $this->serializer = $serializer;
        $this->carRepository = $carRepository;
        $this->filterModelFactory = $filterModelFactory;
    }

    /**
     * @Route("/car/filter", name="eshop_car_filter")
     */
    public function __invoke(Request $request): JsonResponse
    {
        $filterModel = $this->filterModelFactory->createFromRequest($request);

        $cars = $this->carRepository->findByCriteria($filterModel);

        return new JsonResponse(
            $this->serializer->serialize($cars, 'json'),
            Response::HTTP_OK,
            [],
            true
        );
    }
}
