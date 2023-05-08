<?php

declare(strict_types=1);

namespace Impexta\Inquiry\Presentation\Form\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Impexta\Client\Domain\Entity\ClientInterface;
use Impexta\Inquiry\Domain\Entity\InquiryInterface;
use Impexta\Inquiry\Domain\Enum\InquiryOrigin;
use Impexta\User\Domain\Entity\AdminUserInterface;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class InquiryModel implements ModelInterface
{
    /** @Assert\Valid */
    public ?AdminUserInterface $assignee = null;

    /** @Assert\Valid */
    public InquiryOrigin $origin;
    public \DateTimeImmutable $receivedAt;
    public \DateTimeImmutable $expiration;

    /** @Assert\Valid */
    public ClientInterface $client;
    public float $sale = 0;
    public ?string $note = null;

    /**
     * @Assert\Valid
     * @var ArrayCollection<int, InquiryItemRequestModel>
     */
    public Collection $itemRequests;

    public function __construct()
    {
        $this->itemRequests = new ArrayCollection();
    }

    /** @param InquiryInterface $entity */
    public static function createFromEntity(EntityInterface $entity): self
    {
        $model = self::createEmpty();
        $model->assignee = $entity->getAssignee();
        $model->origin = $entity->getOrigin();
        $model->receivedAt = $entity->getReceivedAt();
        $model->expiration = $entity->getExpiration();
        $model->client = $entity->getClient();
        $model->sale = $entity->getSale();
        $model->note = $entity->getNote();

        $itemRequests = [];

        foreach ($entity->getItemRequests() as $itemRequest) {
            $itemRequests[] = InquiryItemRequestModel::createFromEntity($itemRequest);
        }

        $model->itemRequests = new ArrayCollection($itemRequests);

        return $model;
    }

    public static function createEmpty(): self
    {
        return new self();
    }
}
