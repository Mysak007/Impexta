<?php

declare(strict_types=1);

namespace Impexta\Inquiry\Infrastructure\Mapper;

use Http\Discovery\Exception\NotFoundException;
use Impexta\Car\Infrastructure\Repository\CarRepository;
use Impexta\Client\Infrastructure\Repository\ClientCarRepository;
use Impexta\Inquiry\Domain\Entity\InquiryItemRequestInterface;
use Impexta\Inquiry\Domain\Factory\InquiryItemOfferFactory;
use Impexta\Inquiry\Infrastructure\Repository\InquiryItemOfferRepository;
use Impexta\Inquiry\Presentation\Form\Model\InquiryItemRequestModel;

final class InquiryItemRequestMapper
{
    private ClientCarRepository $clientCarRepository;
    private InquiryItemOfferRepository $inquiryItemOfferRepository;
    private CarRepository $carRepository;

    public function __construct(
        ClientCarRepository $clientCarRepository,
        InquiryItemOfferRepository $inquiryItemOfferRepository,
        CarRepository $carRepository
    ) {
        $this->clientCarRepository = $clientCarRepository;
        $this->inquiryItemOfferRepository = $inquiryItemOfferRepository;
        $this->carRepository = $carRepository;
    }

    public function populateFromModel(
        InquiryItemRequestModel $model,
        InquiryItemRequestInterface $inquiryItemRequest
    ): void {
        $clientCar = $this->clientCarRepository->findOneBy(['id' => $model->clientCar]);
        $car = $this->carRepository->findOneBy(['id' => $model->car]);

        if ((!$clientCar || $clientCar->getClient()->getId() !== $model->inquiry->getClient()->getId()) && !$car) {
            throw new NotFoundException('Car not found', 404);
        }

        $inquiryItemRequest->setClientCar($clientCar);
        $inquiryItemRequest->setCar($model->car);
        $inquiryItemRequest->setNote($model->note);
        $inquiryItemRequest->setQuantity($model->quantity);

        $entityOffers = clone $inquiryItemRequest->getItemOffers();

        foreach ($model->itemOffers as $itemOffer) {
            $offer = $this->inquiryItemOfferRepository->findOneBy([
                'inquiryItemRequest' => $inquiryItemRequest,
                'product' => $itemOffer->product,
                'warehouseProduct' => $itemOffer->warehouseProduct]);

            if (!$offer) {
                $offer = InquiryItemOfferFactory::create($itemOffer, $inquiryItemRequest);
                $inquiryItemRequest->addItemOffer($offer);
            }

            $offerToRemove = $entityOffers->filter(static function ($entityOffer) use ($itemOffer) {
                return ($entityOffer->getProduct() === $itemOffer->product) &&
                    ($entityOffer->getWarehouseProduct() === $itemOffer->warehouseProduct);
            })->first();

            if ($offerToRemove === false) {
                continue;
            }

            $offerToRemove->setProduct($itemOffer->product);
            $offerToRemove->setWarehouseProduct($itemOffer->warehouseProduct);
            $offerToRemove->setPrice($itemOffer->price);

            $entityOffers->removeElement($offerToRemove);
        }

        foreach ($entityOffers as $entityOffer) {
            $inquiryItemRequest->removeItemOffer($entityOffer);
            $this->inquiryItemOfferRepository->remove($entityOffer);
        }
    }
}
