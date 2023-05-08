<?php

declare(strict_types=1);

namespace Impexta\Inquiry\Domain\Factory;

use Http\Discovery\Exception\NotFoundException;
use Impexta\Client\Infrastructure\Repository\ClientCarRepository;
use Impexta\Inquiry\Domain\Entity\Inquiry;
use Impexta\Inquiry\Domain\Entity\InquiryItemRequest;
use Impexta\Inquiry\Presentation\Form\Model\InquiryModel;

final class InquiryFactory
{
    private ClientCarRepository $clientCarRepository;

    public function __construct(
        ClientCarRepository $clientCarRepository
    ) {
        $this->clientCarRepository = $clientCarRepository;
    }

    public function create(InquiryModel $inquiryModel): Inquiry
    {
        $inquiry = new Inquiry(
            $inquiryModel->origin,
            $inquiryModel->receivedAt,
            $inquiryModel->expiration,
            $inquiryModel->client
        );

        $inquiry->setAssignee($inquiryModel->assignee);
        $inquiry->setSale($inquiryModel->sale);
        $inquiry->setNote($inquiryModel->note);

        foreach ($inquiryModel->itemRequests as $request) {
            $itemRequest = new InquiryItemRequest(
                $inquiry,
                $request->productCard,
                $request->quantity
            );

            if ($request->clientCar) {
                $clientCar = $this->clientCarRepository->findOneBy(['id' => $request->clientCar]);

                if (!$clientCar || $clientCar->getClient() !== $inquiryModel->client) {
                    throw new NotFoundException('Car not found', 404);
                }

                $itemRequest->setClientCar($clientCar);
            }

            $itemRequest->setCar($request->car);
            $itemRequest->setNote($request->note);

            $inquiry->addItemRequest($itemRequest);
        }

        return $inquiry;
    }
}
