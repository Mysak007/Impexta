<?php

declare(strict_types=1);

namespace Impexta\Inquiry\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Impexta\Client\Domain\Entity\ClientInterface;
use Impexta\Inquiry\Domain\Enum\InquiryOrigin;
use Impexta\User\Domain\Entity\AdminUserInterface;
use Microshop\SymfonySurvivalKit\Doctrine\Entity\TimestampableEntityTrait;

class Inquiry implements InquiryInterface
{
    use TimestampableEntityTrait;

    private int $id;
    private ?AdminUserInterface $assignee = null;
    private InquiryOrigin $origin;
    private \DateTimeImmutable $receivedAt;
    private \DateTimeImmutable $expiration;
    private ClientInterface $client;
    private float $sale;
    private ?string $note = null;

    /** @var ArrayCollection<int,InquiryItemRequestInterface> $itemRequests */
    private Collection $itemRequests;

    public function __construct(
        InquiryOrigin $origin,
        \DateTimeImmutable $receivedAt,
        \DateTimeImmutable $expiration,
        ClientInterface $client,
        float $sale = 0
    ) {
        $this->origin = $origin;
        $this->receivedAt = $receivedAt;
        $this->expiration = $expiration;
        $this->client = $client;
        $this->sale = $sale;
        $this->itemRequests = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAssignee(): ?AdminUserInterface
    {
        return $this->assignee;
    }

    public function setAssignee(?AdminUserInterface $assignee): void
    {
        $this->assignee = $assignee;
    }

    public function getOrigin(): InquiryOrigin
    {
        return $this->origin;
    }

    public function getReceivedAt(): \DateTimeImmutable
    {
        return $this->receivedAt;
    }

    public function getExpiration(): \DateTimeImmutable
    {
        return $this->expiration;
    }

    public function getClient(): ClientInterface
    {
        return $this->client;
    }

    public function getSale(): float
    {
        return $this->sale;
    }

    public function setSale(float $sale): void
    {
        $this->sale = $sale;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): void
    {
        $this->note = $note;
    }

    /**
     * @return ArrayCollection<int, InquiryItemRequestInterface>
     */
    public function getItemRequests(): Collection
    {
        return $this->itemRequests;
    }

    public function addItemRequest(InquiryItemRequestInterface $itemRequest): void
    {
        $this->getItemRequests()->add($itemRequest);
    }

    public function removeItemRequest(InquiryItemRequestInterface $itemRequest): void
    {
        $this->getItemRequests()->removeElement($itemRequest);
    }
}
