<?php

declare(strict_types=1);

namespace Impexta\Inquiry\Infrastructure\Mapper;

use Impexta\Inquiry\Domain\Entity\InquiryInterface;
use Impexta\Inquiry\Domain\Factory\InquiryItemRequestFactory;
use Impexta\Inquiry\Infrastructure\Repository\InquiryItemRequestRepository;
use Impexta\Inquiry\Presentation\Form\Model\InquiryModel;

final class InquiryMapper
{
    private InquiryItemRequestMapper $inquiryItemRequestMapper;
    private InquiryItemRequestRepository $inquiryItemRequestRepository;

    public function __construct(
        InquiryItemRequestMapper $inquiryItemRequestMapper,
        InquiryItemRequestRepository $inquiryItemRequestRepository
    ) {
        $this->inquiryItemRequestMapper = $inquiryItemRequestMapper;
        $this->inquiryItemRequestRepository = $inquiryItemRequestRepository;
    }

    public function populateFromModel(InquiryModel $model, InquiryInterface $inquiry): void
    {
        $inquiry->setAssignee($model->assignee);
        $inquiry->setSale($model->sale);
        $inquiry->setNote($model->note);

        $itemRequestsToRemove = clone $inquiry->getItemRequests();

        foreach ($model->itemRequests as $itemRequestModel) {
            $itemRequestModel->inquiry = $inquiry;
            $itemRequest = $this->inquiryItemRequestRepository->findOneBy([
                'inquiry' => $inquiry,
                'productCard' => $itemRequestModel->productCard,
                'clientCar' => $itemRequestModel->clientCar,
                'car' => $itemRequestModel->car,
            ]);

            if (!$itemRequest) {
                $itemRequest = InquiryItemRequestFactory::create($itemRequestModel, $inquiry);
                $inquiry->addItemRequest($itemRequest);
            }

            $itemRequestToRemove = $itemRequestsToRemove->filter(
                static function ($itemRequestEntity) use ($itemRequestModel) {
                    return (($itemRequestEntity->getClientCar() === $itemRequestModel->clientCar)
                    && ($itemRequestEntity->getCar() === $itemRequestModel->car));
                }
            )->first();

            $this->inquiryItemRequestMapper->populateFromModel($itemRequestModel, $itemRequest);

            if ($itemRequestToRemove === false) {
                continue;
            }

            $itemRequestsToRemove->removeElement($itemRequest);
        }

        foreach ($itemRequestsToRemove as $request) {
            $inquiry->removeItemRequest($request);
            $this->inquiryItemRequestRepository->removeAndSave($request);
        }
    }
}
